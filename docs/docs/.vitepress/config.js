module.exports = {
    title: 'Vite Plugin Documentation',
    description: 'Documentation for the Vite plugin',
    base: '/docs/vite/',
    lang: 'en-US',
    head: [
        ['meta', { content: 'https://github.com/nystudio107', property: 'og:see_also', }],
        ['meta', { content: 'https://twitter.com/nystudio107', property: 'og:see_also', }],
        ['meta', { content: 'https://youtube.com/nystudio107', property: 'og:see_also', }],
        ['meta', { content: 'https://www.facebook.com/newyorkstudio107', property: 'og:see_also', }],
    ],
    themeConfig: {
        repo: 'nystudio107/craft-vite',
        docsDir: 'docs/docs',
        docsBranch: 'develop',
        algolia: {
            apiKey: '7d9dcb02b63eaad3f338be636c5e7fc3',
            indexName: 'vite'
        },
        editLinks: true,
        editLinkText: 'Edit this page on GitHub',
        lastUpdated: 'Last Updated',
        sidebar: 'auto',
    },
};
