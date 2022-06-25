<template>
    <div class="col-12">
        <div class="d-flex align-items-center">
            <div v-if="isLoading" class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h2 class="me-auto ms-2">
                {{  subscriber.name }}
            </h2>
        </div>
    </div>    <div class="col-12">
        <table class="table">
            <tbody>
            <tr>
                <td>#</td>
                <td>{{ subscriber.id }}</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>{{ subscriber.name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ subscriber.email }}</td>
            </tr>
            <tr>
                <td>State</td>
                <td>{{ subscriber.state }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-12" v-if="subscriber.id">
       <FieldsIndex :subscriberId="subscriber.id" />
    </div>
</template>
<script>
import {useFetch} from "../../composable/useFetch";
import FieldsIndex from "../fields/Index"
import {useRoute} from "vue-router";

export default {

    setup({id}) {
        const {isLoading, fetchData, data, error} = useFetch(`api/subscribers/${id}`, {});
        const router = useRoute();
        console.log(router.params.data.user);
        return {
            subscriber: data,
            isLoading,
            error
        }
    },
    components: {
        FieldsIndex
    },
    props: {
        id: Number
    },
}
</script>
