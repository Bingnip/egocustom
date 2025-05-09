<template>
    <!-- 对话框表单 -->
    <!-- 建议使用 Prettier 格式化代码 -->
    <!-- el-form 内可以混用 el-form-item、FormItem、ba-input 等输入组件 -->
    <el-dialog
        class="ba-operate-dialog"
        :close-on-click-modal="false"
        :model-value="['Add', 'Edit'].includes(baTable.form.operate!)"
        @close="baTable.toggleForm"
        width="88%"
        top="5vh"
        :style="{ height: '950px' }"
    >
        <template #header>
            <div class="title" v-drag="['.ba-operate-dialog', '.el-dialog__header']" v-zoom="'.ba-operate-dialog'">
                {{ baTable.form.operate ? t(baTable.form.operate) : '' }}
            </div>
        </template>
        <div
            class="ba-operate-form"
            :class="'ba-' + baTable.form.operate + '-form'"
            :style="config.layout.shrink ? '' : 'width: calc(100% - ' + baTable.form.labelWidth! / 2 + 'px)'"
        >
            <el-form
                v-if="!baTable.form.loading"
                ref="formRef"
                @submit.prevent=""
                @keyup.enter="baTable.onSubmit(formRef)"
                :model="baTable.form.items"
                :label-position="config.layout.shrink ? 'top' : 'right'"
                :label-width="baTable.form.labelWidth + 'px'"
                :rules="rules"
            >
                <FormItem
                    :label="t('cmsManage.page.pb_title')"
                    type="string"
                    v-model="baTable.form.items!.pb_title"
                    prop="pb_title"
                    :placeholder="t('Please input field', { field: t('cmsManage.page.pb_title') })"
                    :inputAttr="{ style: { width: '500px' } }"
                />
                <FormItem
                    :label="t('cmsManage.page.pb_url_key')"
                    type="string"
                    v-model="baTable.form.items!.pb_url_key"
                    prop="pb_url_key"
                    :placeholder="t('Please input field', { field: t('cmsManage.page.pb_url_key') })"
                    :inputAttr="{ style: { width: '500px' } }"
                />
                <FormItem
                    :label="t('State')"
                    type="radio"
                    v-model="baTable.form.items!.pb_status"
                    prop="pb_status"
                    :data="{ childrenAttr: { border: true }, content: { '0': '禁用', '1': '启用' } }"
                    :input-attr="{ fill: '#F56C6C', size: 'default' }"
                    :placeholder="t('Please select field', { field: t('State') })"
                />
                <FormItem
                    :label="t('cmsManage.page.pb_content')"
                    type="editor"
                    prop="pb_content"
                    v-model.number="baTable.form.items!.pb_content"
                    :placeholder="t('Please input field', { field: t('cmsManage.page.pb_content') })"
                />
                <FormItem
                    :label="t('cmsManage.page.pb_meta_title')"
                    type="string"
                    prop="pb_meta_title"
                    v-model.number="baTable.form.items!.pb_meta_title"
                    :placeholder="t('Please input field', { field: t('cmsManage.page.pb_meta_title') })"
                    :inputAttr="{ style: { width: '800px' } }"
                />
                <FormItem
                    :label="t('cmsManage.page.pb_meta_key')"
                    type="textarea"
                    prop="pb_meta_key"
                    v-model.number="baTable.form.items!.pb_meta_key"
                    :placeholder="t('Please input field', { field: t('cmsManage.page.pb_meta_key') })"
                    :input-attr="{ rows: 2 }"
                    :inputAttr="{ style: { width: '800px' } }"
                />
                <FormItem
                    :label="t('cmsManage.page.pb_meta_desc')"
                    type="textarea"
                    prop="pb_meta_desc"
                    v-model.number="baTable.form.items!.pb_meta_desc"
                    :placeholder="t('Please input field', { field: t('cmsManage.page.pb_meta_desc') })"
                    :input-attr="{ rows: 4 }"
                />
            </el-form>
        </div>
        <template #footer>
            <div :style="'width: calc(100% - ' + baTable.form.labelWidth! / 1.8 + 'px)'">
                <el-button @click="baTable.toggleForm()">{{ t('Cancel') }}</el-button>
                <el-button v-blur :loading="baTable.form.submitLoading" @click="baTable.onSubmit(formRef)" type="primary">
                    {{ baTable.form.operateIds && baTable.form.operateIds.length > 1 ? t('Save and edit next item') : t('Save') }}
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script setup lang="ts">
import type { FormInstance, FormItemRule } from 'element-plus'
import { inject, reactive, ref } from 'vue'
import { useI18n } from 'vue-i18n'
import FormItem from '/@/components/formItem/index.vue'
import { useConfig } from '/@/stores/config'
import type baTableClass from '/@/utils/baTable'
import { buildValidatorData } from '/@/utils/validate'

const config = useConfig()
const formRef = ref<FormInstance>()
const baTable = inject('baTable') as baTableClass

const { t } = useI18n()

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
    pb_title: [buildValidatorData({ name: 'required', title: t('cmsManage.page.pb_title'), message: '名称必填' })],
    pb_url_key: [buildValidatorData({ name: 'required', title: t('cmsManage.page.pb_url_key'), message: 'url key 必填' })],
    pb_content: [
        buildValidatorData({
            name: 'editorRequired',
            title: t('cmsManage.page.pb_content'),
            message: '正文 必填',
        }),
    ],
})
</script>

<style scoped lang="scss"></style>
