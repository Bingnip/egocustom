import { adminBaseRoutePath } from '/@/router/static/adminBase'

/*
 * 语言包按需加载映射表
 * 使用固定字符串 ${lang} 指代当前语言
 * key 为页面 path，value 为语言包文件相对路径，访问时，按需自动加载映射表的语言包，同时加载 path 对应的语言包（若存在）
 */
export default {
    '/': ['./frontend/${lang}/index.ts'],
    [adminBaseRoutePath + '/moduleStore']: ['./backend/${lang}/module.ts'],
    [adminBaseRoutePath + '/crud/crud']: ['./backend/${lang}/crud/log.ts', './backend/${lang}/crud/state.ts'],
    [adminBaseRoutePath + '/site/currencyConfig']: ['./backend/${lang}/siteManage/currencyConfig.ts'],
    [adminBaseRoutePath + '/cms/block']: ['./backend/${lang}/cmsManage/block.ts'],
    [adminBaseRoutePath + '/cms/page']: ['./backend/${lang}/cmsManage/page.ts'],
    [adminBaseRoutePath + '/mail/template']: ['./backend/${lang}/mailManage/template.ts'],
    [adminBaseRoutePath + '/mail/sendQueue']: ['./backend/${lang}/mailManage/sendQueue.ts'],
    [adminBaseRoutePath + '/site/shipping']: ['./backend/${lang}/siteManage/shipping.ts'],
    [adminBaseRoutePath + '/marketing/couponRule']: ['./backend/${lang}/marketingManage/couponRule.ts'],
}
