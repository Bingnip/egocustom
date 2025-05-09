<template>
    <el-dialog class="ba-operate-dialog" v-model="dialogVisible" width="80%">
        <template #header>
            <div class="title" v-drag="['.ba-operate-dialog', '.el-dialog__header']" v-zoom="'.ba-operate-dialog'">
                {{ form.title }}
            </div>
        </template>
        <el-scrollbar>
            <div v-html="form.content"></div>
        </el-scrollbar>
    </el-dialog>
</template>

<script setup lang="ts">
import { inject, reactive, ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { useConfig } from '/@/stores/config'
import type baTableClass from '/@/utils/baTable'
import * as SendQueue from '/@/api/backend/mailManage/sendQueue'

const config = useConfig()
const formRef = ref<FormInstance>()
const baTable = inject('baTable') as baTableClass

const { t } = useI18n()

const dialogVisible = ref(false)
const form = ref({
    content: '',
    title: '',
})
const openDialog = (row: any) => {
    dialogVisible.value = true
    SendQueue.getRow(row.eq_id).then((res) => {
        if (res.code) {
            form.value.title = res.data.row.eq_subject
            form.value.content = res.data.row.eq_content
        }
    })
}

defineExpose({
    openDialog,
})
</script>

<style scoped lang="scss"></style>
