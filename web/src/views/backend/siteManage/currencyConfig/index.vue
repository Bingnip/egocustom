<template>
    <div></div>
</template>

<script lang="ts" setup>
import { ref, reactive, onMounted } from 'vue'
import { getList, saveConfig } from '/@/api/backend/siteManage/sysConfig'
import type { TabsPaneContext } from 'element-plus'
import { ElMessage } from 'element-plus'

const activeName = ref('first')

const handleClick = (tab: TabsPaneContext, event: Event) => {
    console.log(tab, event)
}

const submit = (type: number) => {
    saveConfig(type, siteForm).then((res) => {
        if (res.code == 1) {
            ElMessage({
                message: res.msg,
                type: 'success',
                duration: 800,
            })
        }
    })
}

const siteForm = reactive({
    system: [],
    log: [],
    mail: [],
    thirdParty: [],
    other: [],
})

onMounted(async () => {
    var result = await getList()
    if (result.code == 1) {
        Object.assign(siteForm, result.data)
    }
})
</script>

<style scoped></style>
