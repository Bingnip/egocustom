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
                        :label="t('Code')"
                        type="string"
                        v-model="baTable.form.items!.crc_code"
                        prop="crc_code"
                        :placeholder="t('Please input field', { field: t('Code') })"
                    />
                    <FormItem
                        :label="t('currencyConfig.crc_sign')"
                        type="string"
                        v-model="baTable.form.items!.crc_sign"
                        prop="crc_sign"
                        :placeholder="t('Please input field', { field: t('siteManage.currencyConfig.crc_sign') })"
                    />
                    <FormItem
                        :label="t('货币名称')"
                        type="string"
                        v-model="baTable.form.items!.crc_name"
                        prop="crc_name"
                        :placeholder="t('Please input field', { field: t('currency.crc_name') })"
                    />
                    <FormItem
                        :label="t('汇率（与美元）')"
                        type="number"
                        prop="crc_rate"
                        :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.crc_rate"
                        :placeholder="t('Please input field', { field: t('currency.crc_rate') })"
                    />
                    <FormItem
                        :label="t('兑换加收比率')"
                        type="number"
                        prop="crc_exchange_rate"
                        :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.crc_exchange_rate"
                        :placeholder="t('Please input field', { field: t('currency.crc_exchange_rate') })"
                    />
                    <FormItem
                        :label="t('图标')"
                        type="icon"
                        v-model="baTable.form.items!.crc_icon"
                        prop="crc_icon"
                        :input-attr="{ placement: 'top' }"
                        :placeholder="t('Please select field', { field: t('currency.crc_icon') })"
                    />
                    <FormItem
                        :label="t('默认')"
                        type="number"
                        prop="crc_default"
                        :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.crc_default"
                        :placeholder="t('Please input field', { field: t('currency.crc_default') })"
                    />
                    <FormItem
                        :label="t('currency.crc_status')"
                        type="radio"
                        v-model="baTable.form.items!.crc_status"
                        prop="crc_status"
                        :input-attr="{ content: {} }"
                        :placeholder="t('Please select field', { field: t('currency.crc_status') })"
                    />
                    <FormItem
                        :label="t('currency.crc_order')"
                        type="number"
                        prop="crc_order"
                        :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.crc_order"
                        :placeholder="t('Please input field', { field: t('currency.crc_order') })"
                    />
                    <FormItem
                        :label="t('currency.crc_created_at')"
                        type="number"
                        prop="crc_created_at"
                        :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.crc_created_at"
                        :placeholder="t('Please input field', { field: t('currency.crc_created_at') })"
                    />
                    <FormItem
                        :label="t('currency.crc_updated_at')"
                        type="number"
                        prop="crc_updated_at"
                        :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.crc_updated_at"
                        :placeholder="t('Please input field', { field: t('currency.crc_updated_at') })"
                    />
                    <FormItem
                        :label="t('currency.crc_memo')"
                        type="string"
                        v-model="baTable.form.items!.crc_memo"
                        prop="crc_memo"
                        :placeholder="t('Please input field', { field: t('currency.crc_memo') })"
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

const config = useConfig()
const formRef = ref<FormInstance>()
const baTable = inject('baTable') as baTableClass

const { t } = useI18n()

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
    crc_rate: [buildValidatorData({ name: 'number', title: t('currency.crc_rate') })],
    crc_exchange_rate: [buildValidatorData({ name: 'number', title: t('currency.crc_exchange_rate') })],
    crc_default: [buildValidatorData({ name: 'number', title: t('currency.crc_default') })],
    crc_order: [buildValidatorData({ name: 'number', title: t('currency.crc_order') })],
    crc_created_at: [buildValidatorData({ name: 'number', title: t('currency.crc_created_at') })],
    crc_updated_at: [buildValidatorData({ name: 'number', title: t('currency.crc_updated_at') })],
})
</script>

<style scoped lang="scss"></style>
