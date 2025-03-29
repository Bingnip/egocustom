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
                        :label="t('email.queue.eq_id')"
                        type="string"
                        v-model="baTable.form.items!.eq_id"
                        prop="eq_id"
                        :placeholder="t('Please input field', { field: t('email.queue.eq_id') })"
                    />
                    <FormItem
                        :label="t('email.queue.eq_key')"
                        type="string"
                        v-model="baTable.form.items!.eq_key"
                        prop="eq_key"
                        :placeholder="t('Please input field', { field: t('email.queue.eq_key') })"
                    />
                    <FormItem
                        :label="t('email.queue.eq_address')"
                        type="string"
                        v-model="baTable.form.items!.eq_address"
                        prop="eq_address"
                        :placeholder="t('Please input field', { field: t('email.queue.eq_address') })"
                    />
                    <FormItem
                        :label="t('email.queue.eq_name')"
                        type="string"
                        v-model="baTable.form.items!.eq_name"
                        prop="eq_name"
                        :placeholder="t('Please input field', { field: t('email.queue.eq_name') })"
                    />
                    <FormItem
                        :label="t('email.queue.eq_subject')"
                        type="editor"
                        v-model="baTable.form.items!.eq_subject"
                        prop="eq_subject"
                        @keyup.enter.stop=""
                        @keyup.ctrl.enter="baTable.onSubmit(formRef)"
                        :placeholder="t('Please input field', { field: t('email.queue.eq_subject') })"
                    />
                    <FormItem
                        :label="t('email.queue.eq_content')"
                        type="radio"
                        v-model="baTable.form.items!.eq_content"
                        prop="eq_content"
                        :input-attr="{ content: {} }"
                        :placeholder="t('Please select field', { field: t('email.queue.eq_content') })"
                    />
                    <FormItem
                        :label="t('email.queue.eq_created_at')"
                        type="string"
                        v-model="baTable.form.items!.eq_created_at"
                        prop="eq_created_at"
                        :placeholder="t('Please input field', { field: t('email.queue.eq_created_at') })"
                    />
                    <FormItem
                        :label="t('email.queue.eq_status')"
                        type="number"
                        prop="eq_status"
                        :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.eq_status"
                        :placeholder="t('Please input field', { field: t('email.queue.eq_status') })"
                    />
                    <FormItem
                        :label="t('email.queue.eq_rertry')"
                        type="number"
                        prop="eq_rertry"
                        :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.eq_rertry"
                        :placeholder="t('Please input field', { field: t('email.queue.eq_rertry') })"
                    />
                    <FormItem
                        :label="t('email.queue.eq_updated_at')"
                        type="number"
                        prop="eq_updated_at"
                        :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.eq_updated_at"
                        :placeholder="t('Please input field', { field: t('email.queue.eq_updated_at') })"
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
    eq_status: [buildValidatorData({ name: 'number', title: t('email.queue.eq_status') })],
    eq_rertry: [buildValidatorData({ name: 'number', title: t('email.queue.eq_rertry') })],
    eq_updated_at: [buildValidatorData({ name: 'number', title: t('email.queue.eq_updated_at') })],
})
</script>

<style scoped lang="scss"></style>
