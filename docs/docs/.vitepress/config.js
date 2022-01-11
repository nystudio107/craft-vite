module.exports = {
    title: 'Vite Plugin Documentation',
    description: 'Documentation for the Vite plugin',
    base: '/docs/vite/',
    lang: 'en-US',
    head: [
        ['meta', {content: 'https://github.com/nystudio107', property: 'og:see_also',}],
        ['meta', {content: 'https://twitter.com/nystudio107', property: 'og:see_also',}],
        ['meta', {content: 'https://youtube.com/nystudio107', property: 'og:see_also',}],
        ['meta', {content: 'https://www.facebook.com/newyorkstudio107', property: 'og:see_also',}],
    ],
    themeConfig: {
        repo: 'nystudio107/craft-vite',
        docsDir: 'docs/docs',
        docsBranch: 'develop',
        algolia: {
            appId: 'AE3HRUJFEW',
            apiKey: 'c5dcc2be096fff3a4714c3a877a056fa',
            indexName: 'vite'
        },
        editLinks: true,
        editLinkText: 'Edit this page on GitHub',
        lastUpdated: 'Last Updated',
        sidebar: 'auto',
    },
};
