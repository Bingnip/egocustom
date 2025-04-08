<template>
    <!-- 对话框表单 -->
    <!-- 建议使用 Prettier 格式化代码 -->
    <!-- el-form 内可以混用 el-form-item、FormItem、ba-input 等输入组件 -->
    <el-dialog class="ba-operate-dialog" :close-on-click-modal="false"
        :model-value="['Add', 'Edit'].includes(baTable.form.operate!)" @close="baTable.toggleForm" width="50%">
        <template #header>
            <div class="title" v-drag="['.ba-operate-dialog', '.el-dialog__header']" v-zoom="'.ba-operate-dialog'">
                {{ baTable.form.operate ? t(baTable.form.operate) : '' }}
            </div>
        </template>
        <el-scrollbar v-loading="baTable.form.loading" class="ba-table-form-scrollbar">
            <div class="ba-operate-form" :class="'ba-' + baTable.form.operate + '-form'"
                :style="config.layout.shrink ? '':'width: calc(100% - ' + baTable.form.labelWidth! / 2 + 'px)'">
                <el-form v-if="!baTable.form.loading" ref="formRef" @submit.prevent=""
                    @keyup.enter="baTable.onSubmit(formRef)" :model="baTable.form.items"
                    :label-position="config.layout.shrink ? 'top' : 'right'"
                    :label-width="baTable.form.labelWidth + 'px'" :rules="rules">
                    <FormItem :label="t('marketingManage.couponRule.cr_id')" type="string"
                        v-model="baTable.form.items!.cr_id" prop="cr_id"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_id') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_name')" type="string"
                        v-model="baTable.form.items!.cr_name" prop="cr_name"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_name') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_desc')" type="string"
                        v-model="baTable.form.items!.cr_desc" prop="cr_desc"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_desc') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_start_at')" type="number" prop="cr_start_at"
                        :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.cr_start_at"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_start_at') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_end_at')" type="number" prop="cr_end_at"
                        :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.cr_end_at"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_end_at') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_user_use')" type="number" prop="cr_user_use"
                        :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.cr_user_use"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_user_use') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_code_use')" type="number" prop="cr_code_use"
                        :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.cr_code_use"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_code_use') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_status')" type="radio"
                        v-model="baTable.form.items!.cr_status" prop="cr_status" :input-attr="{ content: {} }"
                        :placeholder="t('Please select field', { field: t('marketingManage.couponRule.cr_status') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_conditions')" type="textarea"
                        v-model="baTable.form.items!.cr_conditions" prop="cr_conditions" :input-attr="{ rows: 3 }"
                        @keyup.enter.stop="" @keyup.ctrl.enter="baTable.onSubmit(formRef)"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_conditions') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_disrupt')" type="number" prop="cr_disrupt"
                        :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.cr_disrupt"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_disrupt') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_effect_gid')" type="textarea"
                        v-model="baTable.form.items!.cr_effect_gid" prop="cr_effect_gid" :input-attr="{ rows: 3 }"
                        @keyup.enter.stop="" @keyup.ctrl.enter="baTable.onSubmit(formRef)"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_effect_gid') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_priority')" type="number" prop="cr_priority"
                        :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.cr_priority"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_priority') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_coupon_key')" type="string"
                        v-model="baTable.form.items!.cr_coupon_key" prop="cr_coupon_key"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_coupon_key') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_discount_amount')" type="number"
                        prop="cr_discount_amount" :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.cr_discount_amount"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_discount_amount') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_apply_for_atte')" type="number"
                        prop="cr_apply_for_atte" :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.cr_apply_for_atte"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_apply_for_atte') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_use_times')" type="number" prop="cr_use_times"
                        :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.cr_use_times"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_use_times') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_coupon_type')" type="number"
                        prop="cr_coupon_type" :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.cr_coupon_type"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_coupon_type') })" />
                    <FormItem :label="t('marketingManage.couponRule.cr_auto_generate')" type="number"
                        prop="cr_auto_generate" :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.cr_auto_generate"
                        :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_auto_generate') })" />
                </el-form>
            </div>
        </el-scrollbar>
        <template #footer>
            <div :style="'width: calc(100% - ' + baTable.form.labelWidth! / 1.8 + 'px)'">
                <el-button @click="baTable.toggleForm()">{{ t('Cancel') }}</el-button>
                <el-button v-blur :loading="baTable.form.submitLoading" @click="baTable.onSubmit(formRef)"
                    type="primary">
                    {{ baTable.form.operateIds && baTable.form.operateIds.length > 1 ? t('Save and edit next item') :
                    t('Save') }}
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
    const formRef = ref < FormInstance > ()
    const baTable = inject('baTable') as baTableClass

    const { t } = useI18n()

    const rules: Partial<Record<string, FormItemRule[]>> = reactive({
        cr_start_at: [buildValidatorData({ name: 'date', title: t('marketingManage.couponRule.cr_start_at'), message: '请选择规则开始时间' })],
        cr_end_at: [buildValidatorData({ name: 'date', title: t('marketingManage.couponRule.cr_end_at') })],
        cr_user_use: [buildValidatorData({ name: 'number', title: t('marketingManage.couponRule.cr_user_use') })],
        cr_code_use: [buildValidatorData({ name: 'number', title: t('marketingManage.couponRule.cr_code_use') })],
        cr_disrupt: [buildValidatorData({ name: 'number', title: t('marketingManage.couponRule.cr_disrupt') })],
        cr_priority: [buildValidatorData({ name: 'number', title: t('marketingManage.couponRule.cr_priority') })],
        cr_discount_amount: [buildValidatorData({ name: 'float', title: t('marketingManage.couponRule.cr_discount_amount') })],
        cr_apply_for_atte: [buildValidatorData({ name: 'number', title: t('marketingManage.couponRule.cr_apply_for_atte') })],
        cr_use_times: [buildValidatorData({ name: 'number', title: t('marketingManage.couponRule.cr_use_times') })],
        cr_coupon_type: [buildValidatorData({ name: 'number', title: t('marketingManage.couponRule.cr_coupon_type') })],
        cr_auto_generate: [buildValidatorData({ name: 'number', title: t('marketingManage.couponRule.cr_auto_generate') })],
    })
</script>

<style scoped lang="scss"></style>