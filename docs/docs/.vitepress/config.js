module.exports = {
    title: 'Vite Documentation',
    description: 'Documentation for the Vite plugin',
    base: '/docs/vite/',
    lang: 'en-US',
    themeConfig: {
        repo: 'nystudio107/craft-vite',
        docsDir: 'docs/docs',
        docsBranch: 'v1',
        algolia: {
            apiKey: '7d9dcb02b63eaad3f338be636c5e7fc3',
            indexName: 'vite'
        },
        editLinks: true,
        editLinkText: 'Edit this page on GitHub',
        lastUpdated: 'Last Updated',
    },
};
