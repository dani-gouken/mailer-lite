import Subs from "./subs";
import Fields from "./fields";

import { createWebHashHistory, createRouter } from "vue-router";
const asInt = (route, field) => parseInt(route.params[field]);
const routes = [
    { path: "/", component: Subs.IndexPage, name: "subscriber.index" },
    {
        path: "/subscribers/create",
        component: Subs.CreatePage,
        name: "subscriber.create",
    },
    {
        path: "/subscribers/:subscriberId",
        component: Subs.ShowPage,
        name: "subscriber.show",
    },
    {
        path: "/subscribers/:subscriberId/edit",
        component: Subs.EditPage,
        name: "subscriber.edit",
    },
    {
        path: "/subscribers/:subscriberId/fields/create",
        component: Fields.CreatePage,
        name: "subscriber.field.create",
    },
    {
        path: "/subscribers/:subscriberId/fields/:fieldId/edit",
        component: Fields.EditPage,
        name: "subscriber.field.edit",
    },
];
export const router = createRouter({
    history: createWebHashHistory(),
    routes,
});
