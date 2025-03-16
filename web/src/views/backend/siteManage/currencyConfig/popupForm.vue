<template>
    <!-- 对话框表单 -->
    <!-- 建议使用 Prettier 格式化代码 -->
    <!-- el-form 内可以混用 el-form-item、FormItem、ba-input 等输入组件 -->
    <el-dialog
        class="ba-operate-dialog"
        :close-on-click-modal="false"
        :model-value="['Add', 'Edit'].includes(baTable.form.operate!)"
        @close="baTable.toggleForm"
        width="50%"
    >
        <template #header>
            <div class="title" v-drag="['.ba-operate-dialog', '.el-dialog__header']" v-zoom="'.ba-operate-dialog'">
                {{ baTable.form.operate ? t(baTable.form.operate) : '' }}
            </div>
        </template>
        <el-scrollbar v-loading="baTable.form.loading" class="ba-table-form-scrollbar">
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
                        :label="t('siteManage.currencyConfig.crc_code')"
                        type="string"
                        v-model="baTable.form.items!.crc_code"
                        prop="crc_code"
                        block-help="货币Code，例如：USD"
                        :input-attr="{ maxlength: 3 }"
                        :placeholder="t('Please input field', { field: t('siteManage.currencyConfig.crc_code') })"
                    />
                    <FormItem
                        :label="t('siteManage.currencyConfig.crc_name')"
                        type="string"
                        v-model="baTable.form.items!.crc_name"
                        prop="crc_name"
                        block-help="例如：US Dollar"
                        :placeholder="t('Please input field', { field: t('siteManage.currencyConfig.crc_name') })"
                    />
                    <FormItem
                        :label="t('siteManage.currencyConfig.crc_sign')"
                        type="string"
                        v-model="baTable.form.items!.crc_sign"
                        prop="crc_sign"
                        block-help="例如：$"
                        :placeholder="t('Please input field', { field: t('siteManage.currencyConfig.crc_sign') })"
                    />
                    <FormItem
                        :label="t('siteManage.currencyConfig.crc_icon')"
                        type="image"
                        limit="1"
                        v-model="baTable.form.items!.crc_icon"
                        prop="crc_icon"
                        :input-attr="{ hideSelectFile: true, onChange: onIconChange, onSuccess: onSuccess }"
                        :placeholder="t('Please select field', { field: t('siteManage.currencyConfig.crc_icon') })"
                    />
                    <FormItem
                        :label="t('siteManage.currencyConfig.crc_rate')"
                        type="number"
                        prop="crc_rate"
                        v-model.number="baTable.form.items!.crc_rate"
                        block-help="（100美元可兑换多少此种货币）"
                        :placeholder="t('Please input field', { field: t('siteManage.currencyConfig.crc_name') })"
                    />
                    <FormItem
                        :label="t('siteManage.currencyConfig.crc_exchange_rate')"
                        type="number"
                        prop="crc_exchange_rate"
                        v-model.number="baTable.form.items!.crc_exchange_rate"
                        block-help="（货币兑换需要加收的，汇率会再除以这个得到真正的汇率，请填写小于等于1的数值)"
                        :placeholder="t('Please input field', { field: t('siteManage.currencyConfig.crc_exchange_rate') })"
                    />
                    <FormItem
                        :label="t('siteManage.currencyConfig.crc_default')"
                        type="switch"
                        prop="crc_default"
                        v-model.number="baTable.form.items!.crc_default"
                        block-help="(是否为默认的货币)"
                        :data="{ content: { '1': '是' } }"
                        :placeholder="t('Please input field', { field: t('siteManage.currencyConfig.crc_default') })"
                    />
                    <FormItem
                        :label="t('State')"
                        type="radio"
                        v-model="baTable.form.items!.crc_status"
                        prop="crc_status"
                        :data="{ childrenAttr: { border: true }, content: { '0': '禁用', '1': '启用' } }"
                        :placeholder="t('Please select field', { field: t('State') })"
                    />
                    <FormItem
                        :label="t('siteManage.currencyConfig.crc_order')"
                        type="number"
                        prop="crc_order"
                        :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.crc_order"
                        :placeholder="t('Please input field', { field: t('siteManage.currencyConfig.crc_order') })"
                    />
                    <FormItem
                        :label="t('siteManage.currencyConfig.crc_memo')"
                        type="textarea"
                        v-model="baTable.form.items!.crc_memo"
                        prop="crc_memo"
                        :placeholder="t('Please input field', { field: t('siteManage.currencyConfig.crc_memo') })"
                        :input-attr="{ rows: 3 }"
                    />
                </el-form>
            </div>
        </el-scrollbar>
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
import * as CurrencyConfig from '/@/api/backend/siteManage/currencyConfig'

const config = useConfig()
const formRef = ref<FormInstance>()
const baTable = inject('baTable') as baTableClass

const { t } = useI18n()

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
    crc_code: [buildValidatorData({ name: 'required', title: t('siteManage.currencyConfig.crc_code') })],
    crc_name: [buildValidatorData({ name: 'required', title: t('siteManage.currencyConfig.crc_name') })],
    crc_sign: [buildValidatorData({ name: 'required', title: t('siteManage.currencyConfig.crc_sign') })],
    crc_icon: [buildValidatorData({ name: 'required', title: t('siteManage.currencyConfig.crc_icon') })],
    crc_rate: [buildValidatorData({ name: 'number', title: t('siteManage.currencyConfig.crc_rate') })],
    crc_exchange_rate: [buildValidatorData({ name: 'number', title: t('siteManage.currencyConfig.crc_exchange_rate') })],
    crc_default: [buildValidatorData({ name: 'number', title: t('siteManage.currencyConfig.crc_default') })],
    crc_order: [buildValidatorData({ name: 'number', title: t('siteManage.currencyConfig.crc_order') })],
})

const onIconChange = (uploadFile: UploadFile) => {
    console.log(uploadFile)
}

const onIconSuccess = (res: ApiPromise, uploadFile: UploadFile, uploadFiles: UploadFiles) => {
    console.log(res)
}

const onSubmit = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.validate((valid) => {
        if (valid) {
            console.log(valid)
        }
    })
}
</script>

<style scoped lang="scss"></style>
