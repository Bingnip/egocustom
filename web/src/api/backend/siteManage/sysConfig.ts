import createAxios from '/@/utils/axios'

export const url = '/admin/siteManage.SysConfig/'

export function getList() {
    return createAxios({
        url: url + 'getList',
        method: 'post',
    })
}

export function saveConfig(type: number, form: anyObj = {}) {
    return createAxios({
        url: url + 'saveConfig',
        method: 'post',
        data: { type, form },
    })
}
