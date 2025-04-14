<template>
    <!-- 对话框表单 -->
    <!-- 建议使用 Prettier 格式化代码 -->
    <!-- el-form 内可以混用 el-form-item、FormItem、ba-input 等输入组件 -->
    <el-drawer
        class="ba-operate-dialog"
        :close-on-click-modal="false"
        :model-value="['Add', 'Edit'].includes(baTable.form.operate!)"
        @close="baTable.toggleForm"
        size="56%"
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
                    <el-form-item :label="t('marketingManage.couponRule.cr_name')">
                        <el-input
                            type="text"
                            style="width: 300px"
                            prop="cr_name"
                            :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_name') })"
                        ></el-input>
                    </el-form-item>
                    <el-form-item :label="t('marketingManage.couponRule.cr_desc')">
                        <el-input
                            type="text"
                            style="width: 300px"
                            prop="cr_desc"
                            :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_desc') })"
                        ></el-input>
                    </el-form-item>
                    <el-form-item :label="t('State')">
                        <el-radio-group v-model="baTable.form.items!.cr_status" prop="ship_status">
                            <el-radio border value="0">禁用</el-radio>
                            <el-radio border value="1">启用</el-radio>
                        </el-radio-group>
                    </el-form-item>
                    <el-form-item :label="t('marketingManage.couponRule.cr_coupon_key')">
                        <el-select v-model="baTable.form.items!.cr_coupon_key" style="width: 160px">
                            <el-option value="1" label="特定代码">特定代码</el-option>
                            <el-option value="2" label="自动生成代码">自动生成代码</el-option>
                        </el-select>
                        <el-input
                            v-if="baTable.form.items!.cr_coupon_key == '1'"
                            style="width: 190px; margin-left: 10px"
                            placeholder="请输入优惠券code"
                        ></el-input>
                    </el-form-item>
                    <el-form-item :label="t('marketingManage.couponRule.cr_user_use')">
                        <el-input
                            type="number"
                            style="width: 80px"
                            prop="cr_user_use"
                            v-model="baTable.form.items!.cr_user_use"
                            :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_user_use') })"
                        ></el-input>
                        <span class="block-help-note">(每个优惠码一个用户可使用的次数，0为不限)</span>
                    </el-form-item>
                    <el-form-item :label="t('marketingManage.couponRule.cr_code_use')">
                        <el-input
                            type="number"
                            style="width: 80px"
                            prop="cr_code_use"
                            v-model="baTable.form.items!.cr_code_use"
                            :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_code_use') })"
                        ></el-input>
                        <span class="block-help-note">(每个优惠码可使用的次数，0为不限)</span>
                    </el-form-item>
                    <el-form-item label="时间段">
                        <el-date-picker
                            type="datetimerange"
                            style="width: 200px"
                            start-placeholder="开始时间"
                            end-placeholder="结束时间"
                            :default-time="defaultTime"
                        />
                    </el-form-item>
                    <el-form-item :label="t('marketingManage.couponRule.cr_priority')">
                        <el-input
                            type="number"
                            style="width: 80px"
                            prop="cr_priority"
                            v-model="baTable.form.items!.cr_priority"
                            :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_priority') })"
                        ></el-input>
                        <span class="block-help-note">(越大越靠前)</span>
                    </el-form-item>
                    <el-form-item :label="t('marketingManage.couponRule.cr_coupon_type')">
                        <el-select v-model="baTable.form.items!.cr_coupon_type" style="width: 160px">
                            <el-option value="10" label="金额比率">金额比率</el-option>
                            <el-option value="20" label="固定金额">固定金额</el-option>
                            <el-option value="30" label="购物车总金额">购物车总金额</el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item :label="t('marketingManage.couponRule.cr_discount_amount')">
                        <el-input
                            type="number"
                            style="width: 80px"
                            prop="cr_discount_amount"
                            v-model="baTable.form.items!.cr_discount_amount"
                            :placeholder="t('Please input field', { field: t('marketingManage.couponRule.cr_discount_amount') })"
                        ></el-input>
                        <span class="block-help-note">(如果是折扣请填写小于1的值，0.1表示优惠10%，现价是原价的9折)</span>
                    </el-form-item>
                    <el-form-item :label="t('marketingManage.couponRule.cr_apply_for_attr')">
                        <el-switch
                            prop="cr_apply_for_attr"
                            v-model="baTable.form.items!.cr_apply_for_attr"
                            inline-prompt
                            active-text="是"
                            inactive-text="否"
                        />
                        <span class="block-help-note">(属性金额是否也可以优惠)</span>
                    </el-form-item>
                    <el-form-item :label="t('marketingManage.couponRule.cr_disrupt')">
                        <el-switch prop="cr_disrupt" v-model="baTable.form.items!.cr_disrupt" inline-prompt active-text="是" inactive-text="否" />
                        <span class="block-help-note">(是否不再检测后面的优惠)</span>
                    </el-form-item>
                    <el-form-item :label="t('marketingManage.couponRule.cr_effect_gid')">
                        <el-input
                            type="textarea"
                            prop="cr_effect_gid"
                            v-model="baTable.form.items!.cr_effect_gid"
                            placeholder="如果有填写，表示只对购物车中的此些物品进行优惠，逗号隔开多个，留空表示针对所有物品"
                        ></el-input>
                    </el-form-item>
                    <el-divider border-style="dashed"><span style="">条件（留空表示不限制）</span></el-divider>
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
    </el-drawer>
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

interface RuleForm {
    name: string
    region: string
    count: string
    date1: string
    date2: string
    delivery: boolean
    location: string
    type: string[]
    resource: string
    desc: string
}
</script>

<style scoped lang="scss">
.block-help-note {
    color: #909399;
    size: 11px;
    margin-left: 10px;
}
</style>
