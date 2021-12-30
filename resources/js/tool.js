Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'edit-env',
            path: '/edit-env',
            component: require('./components/Tool'),
        },
    ])
})
