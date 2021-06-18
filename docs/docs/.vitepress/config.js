module.exports = {
    title: 'Vite Documentation',
    description: 'Documentation for the Vite plugin',
    base: '/docs/vite/',
    lang: 'en-US',
    head: [
        [
            'script',
            {},
            "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');ga('create', 'UA-69117511-1', 'auto');ga('require', 'displayfeatures');ga('send', 'pageview');"
        ],
    ],
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
