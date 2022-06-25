import SubscriberIndex from "./components/subscribers/Index"
import SubscriberCreate from "./components/subscribers/Create"
import SubscriberShow from "./components/subscribers/Show"

import {createWebHashHistory, createRouter} from 'vue-router'

const routes = [
    {path: '/', component: SubscriberIndex, name: "subscriber.index"},
    {path: '/subscribers/create', component: SubscriberCreate, name: "subscriber.create"},
    {
        path: '/subscribers/:id(\\d+)', component: SubscriberShow, name: "subscriber.show", props: (route) => {
            const id = Number.parseInt(route.params.id, 10)
            if (Number.isNaN(id)) {
                return 0
            }
            return {id}
        }
    },

]
export const router = createRouter({
    history: createWebHashHistory(),
    routes,
})
