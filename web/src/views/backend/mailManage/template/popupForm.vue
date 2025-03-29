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
        :style="{ height: '880px' }"
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
                    :label="t('mailManage.template.et_title')"
                    type="string"
                    v-model="baTable.form.items!.et_title"
                    prop="et_title"
                    :placeholder="t('Please input field', { field: t('mailManage.template.et_title') })"
                    :inputAttr="{ style: { width: '500px' } }"
                />
                <FormItem
                    :label="t('mailManage.template.et_key')"
                    type="string"
                    v-model="baTable.form.items!.et_key"
                    prop="et_key"
                    :placeholder="t('Please input field', { field: t('mailManage.template.et_key') })"
                    :inputAttr="{ style: { width: '500px' } }"
                />
                <FormItem
                    :label="t('mailManage.template.et_subject')"
                    type="string"
                    v-model="baTable.form.items!.et_subject"
                    prop="et_subject"
                    :placeholder="t('Please input field', { field: t('mailManage.template.et_subject') })"
                    :inputAttr="{ style: { width: '500px' } }"
                />
                <FormItem
                    :label="t('State')"
                    type="radio"
                    v-model="baTable.form.items!.et_status"
                    prop="et_status"
                    :data="{ childrenAttr: { border: true }, content: { '0': '禁用', '1': '启用' } }"
                    :input-attr="{ fill: '#F56C6C', size: 'default' }"
                    :placeholder="t('Please select field', { field: t('State') })"
                />
                <FormItem
                    :label="t('mailManage.template.et_content')"
                    type="editor"
                    v-model="baTable.form.items!.et_content"
                    prop="et_content"
                    @keyup.enter.stop=""
                    @keyup.ctrl.enter="baTable.onSubmit(formRef)"
                    :placeholder="t('Please input field', { field: t('mailManage.template.et_content') })"
                />
                <FormItem
                    :label="t('mailManage.template.et_memo')"
                    type="textarea"
                    v-model="baTable.form.items!.et_memo"
                    prop="et_memo"
                    :placeholder="t('Please input field', { field: t('mailManage.template.et_memo') })"
                    :input-attr="{ rows: 3 }"
                    :inputAttr="{ style: { width: '600px' } }"
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
    et_key: [buildValidatorData({ name: 'required', title: t('mailManage.template.et_key') })],
    et_title: [buildValidatorData({ name: 'required', title: t('mailManage.template.et_title') })],
    et_subject: [buildValidatorData({ name: 'required', title: t('mailManage.template.et_subject') })],
    et_content: [buildValidatorData({ name: 'required', title: t('mailManage.template.et_content') })],
})
</script>

<style scoped lang="scss"></style>
