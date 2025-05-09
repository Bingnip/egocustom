<template>
    <el-button plain @click="openGalleryDialog"> Open a overflow draggable Dialog </el-button>
    <el-dialog v-model="galleryVisible" close-on-press-escape="true" title="上传商品图" style="margin-top: 15vh; width: 1020px" draggable overflow>
        <div>
            <el-container>
                <el-aside width="200px">
                    <el-tree style="max-width: 550px" @node-click="checkedTreeNode" :data="folderList" :props="defaultProps">
                        <template #default="{ node, data }">
                            <div class="tree-block">
                                <div>
                                    <img src="../../assets/folder_icon.jpg" />
                                    <span style="margin-left: 10px; font-size: 13px">
                                        {{ data.af_name }}
                                    </span>
                                </div>
                                <el-dropdown placement="bottom-end">
                                    <Icon name="fa fa-sort-down" size="12" />
                                    <template #dropdown>
                                        <el-dropdown-menu>
                                            <el-dropdown-item>新增分类</el-dropdown-item>
                                            <el-dropdown-item v-if="data.af_id != 1">编辑分类</el-dropdown-item>
                                            <el-dropdown-item v-if="data.af_id != 1">删除</el-dropdown-item>
                                        </el-dropdown-menu>
                                    </template>
                                </el-dropdown>
                            </div>
                        </template>
                    </el-tree>
                </el-aside>
                <el-divider direction="vertical" height="100%" />
                <el-container>
                    <el-header>
                        <el-button type="primary" :disabled="imgCheckedArr.length == 0">使用选中的图片</el-button>
                        <el-button type="primary" @click="openUploadImages">上传图片</el-button>
                        <el-button @click="deleteImgBatch">删除图片</el-button>
                        <el-select
                            @blur="moveImg"
                            clearable
                            :disabled="imgCheckedArr.length == 0"
                            v-model="folderValue"
                            value-key="item.af_id"
                            placeholder="图片移动至"
                            style="width: 170px; margin-left: 10px"
                        >
                            <el-option v-for="item in usedFolderList" :key="item.af_id" :label="item.af_name" :value="item.af_id" />
                        </el-select>
                    </el-header>
                    <el-main class="img-block-container">
                        <div v-if="imageList.length == 0" class="empty-container">
                            <el-empty :image-size="100" />
                        </div>
                        <div v-else v-for="(it, idx) in imageList" class="img-block" :key="it.id">
                            <div class="img-block-parent" @click="imgCheckHandler(idx)">
                                <img :class="['img-block-inner', { 'img-block-inner-checked': it.checked }]" :src="cdnUrl + it.url" :alt="it.name" />
                                <div class="img-block-overlay" v-show="it.checked != null">
                                    <span>{{ it.no }}</span>
                                </div>
                            </div>
                            <div @mouseenter="hoveredIndex = idx" @mouseleave="hoveredIndex = null">
                                <div class="img-title-block" style="height: 26px">
                                    <span v-if="it.rename == null">{{ truncateString(it.name) }}</span>
                                    <el-input @blur="renameSubmit(idx)" size="small" v-else v-model="it.name"> </el-input>
                                </div>
                                <div class="img-oper-block" v-show="hoveredIndex === idx">
                                    <span @click="deleteImgSingle(idx)">删除</span>
                                    <span @click="renameImg(idx)">改名</span>
                                    <span @click="previewImg(idx)">查看</span>
                                </div>
                            </div>
                        </div>
                    </el-main>
                    <el-footer class="footer">
                        <el-pagination
                            v-model:current-page="pagination.currentPage"
                            :page-size="pagination.pageSize"
                            :size="small"
                            :disabled="disabled"
                            background
                            layout="total, prev, pager, next"
                            :total="pagination.total"
                            @current-change="handleCurrentChange"
                        />
                    </el-footer>
                </el-container>
            </el-container>
        </div>
    </el-dialog>
    <el-dialog v-model="uploadDialogVisible" title="上传图片" width="68%">
        <el-form :model="uploadDialogForm" label-width="auto" size="small" style="margin-left: 20px">
            <el-form-item label="上传方式：">
                <el-radio-group v-model="uploadDialogForm.method">
                    <el-radio value="local">本地上传</el-radio>
                    <el-radio value="net">网络上传</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item label="上传至分组：">
                <el-select v-model="uploadDialogForm.uploadTo" value-key="id" style="width: 170px; margin-left: 10px">
                    <el-option v-for="item in options" :key="item.id" :label="item.label" :value="item" />
                </el-select>
            </el-form-item>
            <el-form-item label="上传图片：">
                <el-upload
                    v-model:file-list="uploadDialogForm.uploadImgs"
                    list-type="picture-card"
                    multiple
                    :auto-upload="false"
                    :on-preview="handlePictureCardPreview"
                >
                    <el-icon>
                        <Plus />
                    </el-icon>
                </el-upload>
                <el-dialog v-model="dialogVisible">
                    <img w-full :src="dialogImageUrl" alt="预览图" />
                </el-dialog>
            </el-form-item>
            <el-form-item>
                <span style="color: #bbb; margin-left: 83px">建议上传图片最大宽度750px，不超过3MB；仅支持jpeg、jpg、png格式</span>
            </el-form-item>
        </el-form>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="uploadDialogVisible = false">取消</el-button>
                <el-button type="primary" @click="submitUploadImg">确定</el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { ComponentSize, FormInstance, FormRules, UploadProps, UploadUserFile, ElNotification, ElMessage, ElMessageBox, Action } from 'element-plus'
import { Plus } from '@element-plus/icons-vue'
import { getGalleryList, renameImgSubmit, deleteImage, moveImage } from '/@/api/backend/imageGallery'
import { uuid } from '/@/utils/random'
import { fileUpload, buildSuffixSvgUrl } from '/@/api/common'

const cdnUrl = '//127.0.0.1:8000'
const pagination = reactive({
    currentPage: 1,
    pageSize: 18,
    total: 0,
})
const galleryVisible = ref(false)
const disabled = ref(false)
const searchParams = reactive({ group: 1 })
const hoveredIndex = ref(null)

type Option = {
    id: number
    label: string
    desc: string
}
interface FolderTree {
    label: string
    id: number
}
const folderValue = ref()
const folderList = ref([])
const usedFolderList = ref([])
const defaultProps = {
    label: 'af_name',
    id: 'af_id',
}
const imageList = ref([])
const selectedImgValue = ref([])

const getList = () => {
    let postData = {}
    postData['page'] = pagination.currentPage
    postData['limit'] = pagination.pageSize
    postData['fdId'] = currenctFolderId.value
    getGalleryList(postData).then((res) => {
        if (res.code) {
            folderList.value = res.data.folderList
            usedFolderList.value = res.data.usedFolderList
            imageList.value = res.data.list
            pagination.total = res.data.total
        }
    })
}
const handleCurrentChange = (val: number) => {
    imgCheckedArr.value = []
    pagination.currentPage = val
    getList()
}
const openGalleryDialog = () => {
    imgCheckedArr.value = []
    currenctFolderId.value = 1
    getList()
    galleryVisible.value = true
}

/** 分类操作 START **/
const currenctFolderId = ref(1)
const checkedTreeNode = (node) => {
    currenctFolderId.value = node.af_id
    imgCheckedArr.value = []
    getList()
}
/** 分类操作 END **/

/** 图片操作 START **/
const imgCheckedArr = ref([])
const imgCheckHandler = (idx) => {
    // 图片点击选中操作
    if (!imageList.value[idx].hasOwnProperty('checked')) {
        imageList.value[idx] = { ...imageList.value[idx], checked: true }
        scanCheckedPush(idx)
    } else if (imageList.value[idx].hasOwnProperty('checked')) {
        const { checked, ...rest } = imageList.value[idx]
        imageList.value[idx] = rest
        scanCheckedRemove(imageList.value[idx].id)
    }
}
const scanCheckedPush = (idx) => {
    // 选中
    imgCheckedArr.value.push(imageList.value[idx])
    resetCheckedNo()
}
const scanCheckedRemove = (id) => {
    // 移除
    if (imgCheckedArr.value.length > 0) {
        imgCheckedArr.value.forEach((e, i) => {
            if (e.id == id) {
                imgCheckedArr.value.splice(i, 1)
            }
        })
    }
    resetCheckedNo()
}
const resetCheckedNo = () => {
    // 重新计算选中图片的编号
    if (imgCheckedArr.value.length > 0) {
        imgCheckedArr.value.forEach((e, i) => {
            imageList.value.forEach((e2, i2) => {
                if (e.id == e2.id) {
                    imageList.value[i2] = { ...imageList.value[i2], no: i + 1 }
                }
            })
        })
    }
}
const renameImg = (idx) => {
    // 改名
    imageList.value.forEach((e, i) => {
        if (imageList.value[i].hasOwnProperty('rename') && idx != i) {
            const { rename, ...rest } = imageList.value[i]
            imageList.value[i] = rest
        }
    })
    if (!imageList.value[idx].hasOwnProperty('rename')) {
        imageList.value[idx] = { ...imageList.value[idx], rename: imageList.value[idx].name }
    } else if (imageList.value[idx].hasOwnProperty('rename')) {
        const { rename, ...rest } = imageList.value[idx]
        imageList.value[idx] = rest
    }
}
const renameSubmit = (idx) => {
    // 提交改名
    if (imageList.value[idx].name.trim() == '') {
        ElNotification({
            title: '请填写内容',
            type: 'warning',
        })
        imageList.value[idx].name = imageList.value[idx].rename
        return false
    }
    let postData = {}
    postData['id'] = imageList.value[idx].id
    postData['name'] = imageList.value[idx].name
    renameImgSubmit(postData).then((res) => {
        if (res.code != 1) {
            ElNotification({
                title: '上传错误',
                message: res.msg,
                type: 'error',
            })
        } else {
            const { rename, ...rest } = imageList.value[idx]
            imageList.value[idx] = rest
            ElMessage({
                message: res.msg,
                type: 'success',
                duration: 800,
            })
        }
    })
}
const deleteImgBatch = () => {
    // 批量删除
    if (imgCheckedArr.value.length == 0) {
        ElNotification({
            title: '请选择图片',
            type: 'warning',
        })
        return false
    }
    deleteImage(imgCheckedArr.value.map((item) => item.id)).then((res) => {
        getList()
    })
}
const deleteImgSingle = (idx) => {
    // 单独删除
    ElMessageBox.confirm('确定要删除选中的图片吗？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning',
    }).then(() => {
        deleteImage([imageList.value[idx].id]).then((res) => {
            getList()
        })
    })
}
const previewImg = (idx) => {
    // 查看图片
    buildSuffixSvgUrl(imageList.value[idx].url)
}
const moveImg = () => {
    // 移动图片
    if (imgCheckedArr.value.length == 0 || folderValue.value == undefined) return false

    moveImage(
        folderValue.value,
        imgCheckedArr.value.map((item) => item.id)
    ).then((res) => {
        ElMessage({
            message: res.msg,
            type: 'success',
            duration: 800,
        })
        imgCheckedArr.value = []
        folderValue.value = ''
        getList()
    })
}
/** 图片操作 END **/

/** 图片上传 START **/
interface uploadDialogForm {
    method: string
    uploadTo: string
    uploadImgs: Image[]
}
const uploadDialogVisible = ref(false)
const uploadDialogFormRef = ref<FormInstance>()
const uploadDialogForm = reactive<uploadDialogForm>({ method: 'local', uploadTo: { id: 1, label: '所有图片' }, uploadImgs: [] })
const openUploadImages = () => {
    uploadDialogVisible.value = true
}
const submitUploadImg = (file: any) => {
    let postData = {}
    postData['uploadTo'] = uploadDialogForm.uploadTo
    postData['uuid'] = uuid()
    if (uploadDialogForm.uploadImgs.length > 0) {
        uploadDialogForm.uploadImgs.forEach((ele, idx) => {
            let fd = new FormData()
            fd.append('file', ele.raw)
            fileUpload(fd, postData).then((res) => {
                if (res.code != 1) {
                    ElNotification({
                        title: '上传错误',
                        message: res.msg,
                        type: 'error',
                    })
                }
            })
        })
        uploadDialogVisible.value = false
    }
}
/** 图片上传 END **/

const uploadImagesList = ref<UploadUserFile[]>([])
const dialogImageUrl = ref('')
const dialogVisible = ref(false)
const handlePictureCardPreview: UploadProps['onPreview'] = (uploadFile) => {
    dialogImageUrl.value = uploadFile.url!
    dialogVisible.value = true
}

const truncateString = (str, frontChars = 4, endChars = 5) => {
    if (str.length <= frontChars + endChars + 3) {
        return str // 不需要截断
    }
    const front = str.slice(0, frontChars) // 获取前面的部分
    const end = str.slice(-endChars) // 获取后面的部分
    return `${front}...${end}` // 组合并返回
}
</script>

<style scoped lang="scss">
.img-block-parent {
    height: 100px;
    height: 100px;
    background-color: #f8f8f8;
    position: relative;
    display: inline-block;
}

.img-block-overlay {
    display: flex;
    background-color: #337ecc;
    width: 20px;
    height: 20px;
    color: white;
    border: 1px solid white;
    border-radius: 20px;
    position: absolute;
    justify-content: center;
    align-items: center;
    top: 3px;
    right: 3px;
}

.img-block-overlay > span {
    font-size: 12px;
}

.img-block-inner {
    width: 100px;
    height: 100px;
    border: 2px solid white;
    object-fit: contain;
}

.img-block-inner-checked {
    width: 100px;
    height: 100px;
    border: 2px solid #337ecc;
    object-fit: contain;
}

.img-block-container {
    display: flex;
    flex-flow: row wrap;
    align-content: flex-start;
    height: 501px;
    margin-top: -20px;
}

.img-oper-block {
    height: 18px;
    display: flex;
    justify-content: space-around;
}

.img-oper-block span {
    font-size: 12px;
    color: #337ecc;
}

.img-block {
    width: 100px;
    height: 146px;
    margin: 2px 10px;
    cursor: pointer;
}

.img-title-block {
    height: 17px;
    font-size: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
}

::v-deep .el-upload--picture-card {
    width: 80px;
    height: 80px;
    line-height: 80px;
}

::v-deep .el-upload-list--picture-card .el-upload-list__item {
    width: 80px !important;
    height: 80px !important;
}

.footer {
    display: grid;
    place-items: center;
    height: 60px;
    margin-top: -25px;
}

.empty-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 400px;
}

.tree-block {
    display: flex;
    justify-content: space-between;
    width: 164px;
}

.el-tree-node__label {
    font-size: 22px;
}

.el-tree-node__content {
    height: 50px;
}
</style>
