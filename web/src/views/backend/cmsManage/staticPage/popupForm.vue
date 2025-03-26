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
                    <FormItem :label="t('static.page.pb_id')" type="string" v-model="baTable.form.items!.pb_id"
                        prop="pb_id" :placeholder="t('Please input field', { field: t('static.page.pb_id') })" />
                    <FormItem :label="t('static.page.pb_title')" type="string" v-model="baTable.form.items!.pb_title"
                        prop="pb_title" :placeholder="t('Please input field', { field: t('static.page.pb_title') })" />
                    <FormItem :label="t('static.page.pb_url_key')" type="string"
                        v-model="baTable.form.items!.pb_url_key" prop="pb_url_key"
                        :placeholder="t('Please input field', { field: t('static.page.pb_url_key') })" />
                    <FormItem :label="t('State')" type="number" prop="pb_status" :input-attr="{ step: 1 }"
                        v-model.number="baTable.form.items!.pb_status"
                        :placeholder="t('Please input field', { field: t('static.page.pb_status') })" />
                    <FormItem :label="t('static.page.pb_created_at')" type="number" prop="pb_created_at"
                        :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.pb_created_at"
                        :placeholder="t('Please input field', { field: t('static.page.pb_created_at') })" />
                    <FormItem :label="t('static.page.pb_updated_at')" type="number" prop="pb_updated_at"
                        :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.pb_updated_at"
                        :placeholder="t('Please input field', { field: t('static.page.pb_updated_at') })" />
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
        pb_title: [buildValidatorData({ name: 'required', title: t('static.page.pb_title'), message: '名称必填' })],
        pb_url_key: [buildValidatorData({ name: 'required', title: t('static.page.pb_url_key'), message: 'url key 必填' })],
        pb_content: [buildValidatorData({ name: 'editorRequired', title: t('static.page.pb_content') })],
        pb_status: [buildValidatorData({ name: 'number', title: t('static.page.pb_status') })],
        pb_created_at: [buildValidatorData({ name: 'number', title: t('static.page.pb_created_at') })],
        pb_updated_at: [buildValidatorData({ name: 'number', title: t('static.page.pb_updated_at') })],
        pb_deleted_at: [buildValidatorData({ name: 'number', title: t('static.page.pb_deleted_at') })],
    })
</script>

<style scoped lang="scss"></style>