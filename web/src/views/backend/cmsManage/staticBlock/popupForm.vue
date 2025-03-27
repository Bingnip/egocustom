<template>
    <!-- 对话框表单 -->
    <!-- 建议使用 Prettier 格式化代码 -->
    <!-- el-form 内可以混用 el-form-item、FormItem、ba-input 等输入组件 -->
    <el-dialog class="ba-operate-dialog" :close-on-click-modal="false"
        :model-value="['Add', 'Edit'].includes(baTable.form.operate!)" @close="baTable.toggleForm" width="75%"
        :style="{ height: '800px' }">
        <template #header>
            <div class="title" v-drag="['.ba-operate-dialog', '.el-dialog__header']" v-zoom="'.ba-operate-dialog'">
                {{ baTable.form.operate ? t(baTable.form.operate) : '' }}
            </div>
        </template>
        <div class="ba-operate-form" :class="'ba-' + baTable.form.operate + '-form'"
            :style="config.layout.shrink ? '' : 'width: calc(100% - ' + baTable.form.labelWidth! / 2 + 'px)'">
            <el-form v-if="!baTable.form.loading" ref="formRef" @submit.prevent=""
                @keyup.enter="baTable.onSubmit(formRef)" :model="baTable.form.items"
                :label-position="config.layout.shrink ? 'top' : 'right'" :label-width="baTable.form.labelWidth + 'px'"
                :rules="rules">
                <FormItem :label="t('cmsManage.block.cb_name')" type="string" v-model="baTable.form.items!.cb_name"
                    prop="cb_name" :placeholder="t('Please input field', { field: t('cmsManage.block.cb_name') })"
                    :inputAttr="{ style: { width: '700px' } }" />
                <FormItem :label="t('cmsManage.block.cb_key')" type="string" v-model="baTable.form.items!.cb_key"
                    prop="cb_key" block-help="仅限小写字母、数字和下划线"
                    :placeholder="t('Please input field', { field: t('cmsManage.block.cb_key') })"
                    :inputAttr="{ style: { width: '700px' } }" />
                <FormItem :label="t('State')" type="switch" v-model="baTable.form.items!.cb_status" prop="cb_status"
                    :placeholder="t('Please select field', { field: t('State') })" />
                <FormItem :label="t('State')" type="radio" v-model="baTable.form.items!.cb_status" prop="cb_status"
                    :data="{ childrenAttr: { border: true }, content: { '0': '禁用', '1': '启用' } }"
                    :placeholder="t('Please select field', { field: t('State') })" />
                <FormItem :label="t('cmsManage.block.cb_content')" type="editor"
                    v-model="baTable.form.items!.cb_content" prop="cb_content"
                    :placeholder="t('Please select field', { field: t('cmsManage.block.cb_content') })" />
                <FormItem :label="t('cmsManage.block.cb_memo')" type="textarea" v-model="baTable.form.items!.cb_memo"
                    prop="cb_memo" :placeholder="t('Please select field', { field: t('cmsManage.block.cb_memo') })"
                    :input-attr="{ rows: 2 }" :inputAttr="{ style: { width: '700px' } }" />
            </el-form>
        </div>
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
    import * as StaticBlock from '/@/api/backend/cmsManage/block'

    const config = useConfig()
    const formRef = ref < FormInstance > ()
    const baTable = inject('baTable') as baTableClass

    const { t } = useI18n()

    const rules: Partial<Record<string, FormItemRule[]>> = reactive({
        cb_name: [buildValidatorData({ name: 'required', title: t('cmsManage.block.cb_name') })],
        cb_key: [buildValidatorData({ name: 'required', title: t('cmsManage.block.cb_key') })],
        cb_content: [buildValidatorData({ name: 'required', title: t('cmsManage.block.cb_content') })],
    })
</script>

<style scoped lang="scss"></style>