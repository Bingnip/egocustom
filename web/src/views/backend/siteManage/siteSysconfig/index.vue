<template>
    <div class="default-main">
        <el-form :model="siteForm.sysConfig" label-width="auto" size="small">
            <el-tabs :tab-position="tabPosition" class="demo-tabs site-form">
                <el-tab-pane label="系统参数">
                    <el-form-item v-for="(item, idx) in list.system" :key="idx" :label="item.sc_title">
                        <el-input v-model="item.sc_value" />
                        <span v-if="item.sc_desc != ''" class="site-form-memo">{{ item.sc_desc }}</span>
                    </el-form-item>
                </el-tab-pane>
                <el-tab-pane label="LOGO">
                    <el-form-item v-for="(item, idx) in list.logo" :key="idx" :label="item.sc_title">
                        <el-input v-model="item.sc_value" />
                        <span v-if="item.sc_desc != ''" class="site-form-memo">{{ item.sc_desc }}</span>
                    </el-form-item>
                </el-tab-pane>
                <el-tab-pane label="邮件">
                    <el-form-item v-for="(item, idx) in list.mail" :key="idx" :label="item.sc_title">
                        <el-input v-model="item.sc_value" />
                        <span v-if="item.sc_desc != ''" class="site-form-memo">{{ item.sc_desc }}</span>
                    </el-form-item>
                </el-tab-pane>
                <el-tab-pane label="第三方">
                    <el-form-item v-for="(item, idx) in list.thirdParty" :key="idx" :label="item.sc_title">
                        <el-input v-model="item.sc_value" />
                        <span v-if="item.sc_desc != ''" class="site-form-memo">{{ item.sc_desc }}</span>
                    </el-form-item>
                </el-tab-pane>
                <el-tab-pane label="其他">
                    <el-form-item v-for="(item, idx) in list.other" :key="idx" :label="item.sc_title">
                        <el-input v-model="item.sc_value" />
                        <span v-if="item.sc_desc != ''" class="site-form-memo">{{ item.sc_desc }}</span>
                    </el-form-item>
                </el-tab-pane>
            </el-tabs>
        </el-form>
    </div>
</template>

<script lang="ts" setup>
    import { ref, reactive, onMounted } from 'vue'
    import { getList } from '/@/api/backend/siteManage/crud'
    import type { TabsPaneContext } from 'element-plus'

    const activeName = ref('first')

    const handleClick = (tab: TabsPaneContext, event: Event) => {
        console.log(tab, event)
    }

    const siteForm = reactive({
        siteName: '',
        metaTitle: '',
        metaTitlePrefix: '',
        metaDesc: '',
        metaKeywords: '',
        welcomeText: '',
        copyright: '',
        contactEmail: '',
        sysLanuage: '',
        domain: '',
        siteUrl: '',
        contactPhone: '',
        mailSender: '',
        mailUseSmtp: '',
        logoAlt: '',
        smtpHost: '',
        smtpPort: '',
        smtpMail: '',
        smtpUser: '',
        smtpPwd: '',
        assetsCdnUrl: '',
        mediaCdnUrl: '',
        fbFansPage: '',
        fbCapi: '',
        fbPixelId: '',
        googleGtm: '',
        gtagCartLabel: '',
        gtagSuccessLabel: '',
        gtagAccountId: '',
    })

    let list = reactive({})

    onMounted(async () => {
        var result = await getList()
        if (result.code == 1) {
            list = result.data
        }
    })

</script>

<style scoped>
    .default-main {
        background-color: white;
    }

    .demo-tabs {
        padding: 4px 12px 6px 12px;
        color: #6b778c;
        font-size: 32px;
        font-weight: 600;
    }

    .site-form {
        max-width: 600px;
        font-weight: normal;
    }

    .site-form-memo {
        color: #c0c4cc;
        font-size: 12px;
    }
</style>