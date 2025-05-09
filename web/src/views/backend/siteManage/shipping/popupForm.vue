<template>
    <!-- 对话框表单 -->
    <!-- 建议使用 Prettier 格式化代码 -->
    <!-- el-form 内可以混用 el-form-item、FormItem、ba-input 等输入组件 -->
    <el-dialog
        class="ba-operate-dialog"
        :close-on-click-modal="false"
        :model-value="['Add', 'Edit'].includes(baTable.form.operate!)"
        @close="baTable.toggleForm"
        width="68%"
        top="5vh"
        :style="{ height: '880px' }"
    >
        <template #header>
            <div class="title" v-drag="['.ba-operate-dialog', '.el-dialog__header']" v-zoom="'.ba-operate-dialog'">
                {{ baTable.form.operate ? t(baTable.form.operate) : '' }}
            </div>
        </template>
        <el-scrollbar v-loading="baTable.form.loading" class="ba-table-form-scrollbar" :style="{ height: '700px' }">
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
                        :label="t('siteManage.shipping.ship_name')"
                        type="string"
                        v-model="baTable.form.items!.ship_name"
                        prop="ship_name"
                        :placeholder="t('Please input field', { field: t('siteManage.shipping.ship_name') })"
                        :inputAttr="{ style: { width: '400px' } }"
                    />
                    <FormItem
                        :label="t('siteManage.shipping.ship_code')"
                        type="string"
                        v-model="baTable.form.items!.ship_code"
                        prop="ship_code"
                        :placeholder="t('Please input field', { field: t('siteManage.shipping.ship_code') })"
                        :inputAttr="{ style: { width: '400px' } }"
                        block-help="（必须唯一）"
                    />
                    <FormItem
                        :label="t('siteManage.shipping.ship_full_name')"
                        type="string"
                        v-model="baTable.form.items!.ship_full_name"
                        prop="ship_full_name"
                        :placeholder="t('Please input field', { field: t('siteManage.shipping.ship_full_name') })"
                        :inputAttr="{ style: { width: '400px' } }"
                    />
                    <FormItem
                        :label="t('State')"
                        type="radio"
                        v-model="baTable.form.items!.ship_status"
                        prop="ship_status"
                        :data="{ childrenAttr: { border: true }, content: { '0': '禁用', '1': '启用' } }"
                        :placeholder="t('Please select field', { field: t('State') })"
                    />
                    <FormItem
                        :label="t('siteManage.shipping.ship_desc')"
                        type="textarea"
                        v-model="baTable.form.items!.ship_desc"
                        prop="ship_desc"
                        :placeholder="t('Please input field', { field: t('siteManage.shipping.ship_desc') })"
                        :input-attr="{ rows: 2 }"
                        :inputAttr="{ style: { width: '800px' } }"
                    />
                    <FormItem
                        :label="t('siteManage.shipping.ship_order')"
                        type="number"
                        prop="ship_order"
                        :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.ship_order"
                        :placeholder="t('Please input field', { field: t('siteManage.shipping.ship_order') })"
                        :inputAttr="{ style: { width: '90px' } }"
                    />
                    <el-form-item label="需要电话">
                        <el-switch v-model="baTable.form.items!.tel_required"></el-switch>
                    </el-form-item>
                    <FormItem
                        :label="t('siteManage.shipping.base_fee')"
                        type="number"
                        prop="base_fee"
                        v-model.number="baTable.form.items!.base_fee"
                        :placeholder="t('Please input field', { field: t('siteManage.shipping.base_fee') })"
                        :inputAttr="{ style: { width: '100px' } }"
                        block-help="（基础运费）"
                    />
                    <FormItem
                        :label="t('siteManage.shipping.free_amount')"
                        type="number"
                        prop="free_amount"
                        v-model.number="baTable.form.items!.free_amount"
                        :placeholder="t('Please input field', { field: t('siteManage.shipping.free_amount') })"
                        :inputAttr="{ style: { width: '100px' } }"
                        block-help="（购物车免运金额，0.00为不免）"
                    />
                    <FormItem
                        :label="t('siteManage.shipping.ship_html_desc')"
                        type="editor"
                        v-model="baTable.form.items!.ship_html_desc"
                        prop="ship_html_desc"
                        :placeholder="t('Please input field', { field: t('siteManage.shipping.ship_html_desc') })"
                        :inputAttr="{ style: { width: '800px' } }"
                    />
                    <FormItem
                        :label="t('siteManage.shipping.accept_country')"
                        type="string"
                        v-model="baTable.form.items!.accept_country"
                        prop="accept_country"
                        :placeholder="t('Please input field', { field: t('siteManage.shipping.accept_country') })"
                        block-help="(进行IP判断展示的国家，空为表示对所有开放，示例:US,CA,UK 表示只针对US,CA,UK的IP用户展示)"
                        :inputAttr="{ style: { width: '700px' } }"
                    />
                    <FormItem
                        :label="t('siteManage.shipping.deny_country')"
                        type="string"
                        v-model="baTable.form.items!.deny_country"
                        prop="deny_country"
                        :placeholder="t('Please input field', { field: t('siteManage.shipping.deny_country') })"
                        block-help="(进行IP判断不展示的国家，空为表示对所有开放，示例:US,CA,UK 表示该物流选项针对US,CA,UK的IP用户不展示)"
                        :inputAttr="{ style: { width: '700px' } }"
                    />
                    <el-form-item label="时效天数">
                        <el-col :span="1">
                            <el-input style="width: 60px" prop="deliver_min_days" v-model.number="baTable.form.items!.deliver_min_days" />
                        </el-col>
                        <el-col :span="1">
                            <span style="color: #909399; margin-left: 23px">—</span>
                        </el-col>
                        <el-col :span="1">
                            <el-input style="width: 60px" prop="deliver_max_days" v-model.number="baTable.form.items!.deliver_max_days" />
                        </el-col>
                        <el-col :span="2">
                            <span style="color: #909399; margin-left: 20px">（天）</span>
                        </el-col>
                    </el-form-item>
                    <FormItem
                        :label="t('siteManage.shipping.deliver_string')"
                        type="textarea"
                        v-model="baTable.form.items!.deliver_string"
                        prop="deliver_string"
                        :placeholder="t('Please input field', { field: t('siteManage.shipping.deliver_string') })"
                        :input-attr="{ rows: 2 }"
                        :inputAttr="{ style: { width: '800px' } }"
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
    ship_name: [buildValidatorData({ name: 'required', title: t('siteManage.shipping.ship_name'), message: '前台物流名必填' })],
    ship_full_name: [buildValidatorData({ name: 'required', title: t('siteManage.shipping.ship_full_name'), message: '物流全称必填' })],
    ship_code: [buildValidatorData({ name: 'required', title: t('siteManage.shipping.ship_code'), message: '物流Code必填' })],
})
</script>

<style scoped lang="scss"></style>
