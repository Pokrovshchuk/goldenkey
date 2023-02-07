require('./bootstrap');

require('alpinejs');

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

(async () => {
    await axios.post('/api/login', {
        'email': 'arm2@gmail.com',
        'password': 'qweqweqwe',
    }).then(r => {
        axios.defaults.headers.common['Authorization'] = `Bearer ${r.data.token}`
        console.log('logged in')

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '1f81edf1fa54a7692267',
            cluster: 'eu',
            forceTLS: true,
            auth: {
                headers: {
                    Authorization: `Bearer ${r.data.token}`
                }
            }
        });

        window.Echo.private(`orders.new.${r.data.user_id}`)
            .listen('OrderCreatedEvent', (e) => {
                console.log('order created event');
            });

        console.log(`connected to orders.new.${r.data.user_id}`)
    })

    await axios.post('/api/tinkoff/order').then(r => {
        const orderId = r.data.data.order_id

        window.Echo.private(`orders.updated.${orderId}`)
            .listen('OrderUpdatedEvent', (e) => {
                console.log('order updated');
            });

        console.log(`connected to orders.updated.${orderId}`)
    })
})()
