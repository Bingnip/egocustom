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
                :style="config.layout.shrink ? '':'width: calc(100% - ' + baTable.form.labelWidth! / 2 + 'px)'"
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
                    <FormItem :label="t('shipping.ship_name')" type="string" v-model="baTable.form.items!.ship_name" prop="ship_name" :placeholder="t('Please input field', { field: t('shipping.ship_name') })" />
                    <FormItem :label="t('shipping.ship_full_name')" type="string" v-model="baTable.form.items!.ship_full_name" prop="ship_full_name" :placeholder="t('Please input field', { field: t('shipping.ship_full_name') })" />
                    <FormItem :label="t('shipping.ship_code')" type="string" v-model="baTable.form.items!.ship_code" prop="ship_code" :placeholder="t('Please input field', { field: t('shipping.ship_code') })" />
                    <FormItem :label="t('shipping.ship_desc')" type="string" v-model="baTable.form.items!.ship_desc" prop="ship_desc" :placeholder="t('Please input field', { field: t('shipping.ship_desc') })" />
                    <FormItem :label="t('shipping.ship_html_desc')" type="string" v-model="baTable.form.items!.ship_html_desc" prop="ship_html_desc" :placeholder="t('Please input field', { field: t('shipping.ship_html_desc') })" />
                    <FormItem :label="t('shipping.ship_order')" type="number" prop="ship_order" :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.ship_order" :placeholder="t('Please input field', { field: t('shipping.ship_order') })" />
                    <FormItem :label="t('shipping.ship_status')" type="number" prop="ship_status" :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.ship_status" :placeholder="t('Please input field', { field: t('shipping.ship_status') })" />
                    <FormItem :label="t('shipping.deliver_string')" type="string" v-model="baTable.form.items!.deliver_string" prop="deliver_string" :placeholder="t('Please input field', { field: t('shipping.deliver_string') })" />
                    <FormItem :label="t('shipping.deliver_min_days')" type="number" prop="deliver_min_days" :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.deliver_min_days" :placeholder="t('Please input field', { field: t('shipping.deliver_min_days') })" />
                    <FormItem :label="t('shipping.deliver_max_days')" type="number" prop="deliver_max_days" :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.deliver_max_days" :placeholder="t('Please input field', { field: t('shipping.deliver_max_days') })" />
                    <FormItem :label="t('shipping.tel_required')" type="number" prop="tel_required" :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.tel_required" :placeholder="t('Please input field', { field: t('shipping.tel_required') })" />
                    <FormItem :label="t('shipping.base_fee')" type="number" prop="base_fee" :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.base_fee" :placeholder="t('Please input field', { field: t('shipping.base_fee') })" />
                    <FormItem :label="t('shipping.free_amount')" type="number" prop="free_amount" :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.free_amount" :placeholder="t('Please input field', { field: t('shipping.free_amount') })" />
                    <FormItem :label="t('shipping.accept_country')" type="string" v-model="baTable.form.items!.accept_country" prop="accept_country" :placeholder="t('Please input field', { field: t('shipping.accept_country') })" />
                    <FormItem :label="t('shipping.deny_country')" type="string" v-model="baTable.form.items!.deny_country" prop="deny_country" :placeholder="t('Please input field', { field: t('shipping.deny_country') })" />
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
    ship_name: [buildValidatorData({ name: 'required', title: t('shipping.ship_name'), message: '前台物流名必填' })],
    ship_code: [buildValidatorData({ name: 'required', title: t('shipping.ship_code'), message: '物流Code必填' })],
    ship_order: [buildValidatorData({ name: 'number', title: t('shipping.ship_order') })],
    ship_status: [buildValidatorData({ name: 'number', title: t('shipping.ship_status') })],
    deliver_min_days: [buildValidatorData({ name: 'number', title: t('shipping.deliver_min_days') })],
    deliver_max_days: [buildValidatorData({ name: 'number', title: t('shipping.deliver_max_days') })],
    tel_required: [buildValidatorData({ name: 'number', title: t('shipping.tel_required') })],
    base_fee: [buildValidatorData({ name: 'float', title: t('shipping.base_fee') })],
    free_amount: [buildValidatorData({ name: 'float', title: t('shipping.free_amount') })],
})
</script>

<style scoped lang="scss"></style>
