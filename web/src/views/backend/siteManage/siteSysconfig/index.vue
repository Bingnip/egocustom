<template>
    <div class="default-main">
        <el-form :model="siteForm" label-width="auto" size="small">
            <el-tabs :tab-position="tabPosition" class="demo-tabs site-form">
                <el-tab-pane label="系统参数">
                    <el-form-item v-for="(item, idx) in siteForm.system" :key="idx" :label="item.sc_title">
                        <el-input v-model="item.sc_value" />
                        <span v-if="item.sc_desc != ''" class="site-form-memo">{{ item.sc_desc }}</span>
                    </el-form-item>
                    <el-form-item label=" ">
                        <el-button type="primary" size="small" @click="submit(10)">提交</el-button>
                    </el-form-item>
                </el-tab-pane>
                <el-tab-pane label="LOGO">
                    <el-form-item v-for="(item, idx) in siteForm.logo" :key="idx" :label="item.sc_title">
                        <el-input v-model="item.sc_value" />
                        <span v-if="item.sc_desc != ''" class="site-form-memo">{{ item.sc_desc }}</span>
                    </el-form-item>
                    <el-form-item label=" ">
                        <el-button type="primary" size="small" @click="submit(20)">提交</el-button>
                    </el-form-item>
                </el-tab-pane>
                <el-tab-pane label="邮件">
                    <el-form-item v-for="(item, idx) in siteForm.mail" :key="idx" :label="item.sc_title">
                        <el-input v-model="item.sc_value" />
                        <span v-if="item.sc_desc != ''" class="site-form-memo">{{ item.sc_desc }}</span>
                    </el-form-item>
                    <el-form-item label=" ">
                        <el-button type="primary" size="small" @click="submit(30)">提交</el-button>
                    </el-form-item>
                </el-tab-pane>
                <el-tab-pane label="第三方">
                    <el-form-item v-for="(item, idx) in siteForm.thirdParty" :key="idx" :label="item.sc_title">
                        <el-input v-model="item.sc_value" />
                        <span v-if="item.sc_desc != ''" class="site-form-memo">{{ item.sc_desc }}</span>
                    </el-form-item>
                    <el-form-item label=" ">
                        <el-button type="primary" size="small" @click="submit(40)">提交</el-button>
                    </el-form-item>
                </el-tab-pane>
                <el-tab-pane label="其他">
                    <el-form-item v-for="(item, idx) in siteForm.other" :key="idx" :label="item.sc_title">
                        <el-input v-model="item.sc_value" />
                        <span v-if="item.sc_desc != ''" class="site-form-memo">{{ item.sc_desc }}</span>
                    </el-form-item>
                    <el-form-item label=" ">
                        <el-button type="primary" size="small" @click="submit(50)">提交</el-button>
                    </el-form-item>
                </el-tab-pane>
            </el-tabs>
        </el-form>
    </div>
</template>

<script lang="ts" setup>
import { ref, reactive, onMounted } from 'vue'
import { getList, saveConfig } from '/@/api/backend/siteManage/crud'
import type { TabsPaneContext } from 'element-plus'

const activeName = ref('first')

const handleClick = (tab: TabsPaneContext, event: Event) => {
    console.log(tab, event)
}

const submit = (type: number) => {
    saveConfig(type, siteForm).then((res) => {
        console.log(res)
    })
}

const siteForm = reactive({
    system: [],
    log: [],
    mail: [],
    thirdParty: [],
    other: [],
})

onMounted(async () => {
    var result = await getList()
    if (result.code == 1) {
        Object.assign(siteForm, result.data)
    }
})
</script>

<style scoped>
.default-main {
    background-color: white;
}

.demo-tabs {
    padding: 4px 12px 6px 12px;
    color: #6b778c;
    font-size: 32px;
    font-weight: 600;
}

.site-form {
    max-width: 600px;
    font-weight: normal;
}

.site-form-memo {
    color: #c0c4cc;
    font-size: 12px;
}
</style>
