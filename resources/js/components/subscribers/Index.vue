<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <div v-if="isLoading" class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h2 class="me-auto ms-2">
                        Subscribers
                    </h2>
                    <p>
                        <router-link tag="button" :to='{name: "subscriber.create"}'>
                            <button type="button" class="btn btn-primary">Create</button>
                        </router-link>
                    </p>
                </div>
            </div>
            <div class="col-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">State</th>
                        <th scope="col">Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="subscriber in data">
                        <th scope="row">{{ subscriber.id }}</th>
                        <td>{{ subscriber.name }}</td>
                        <td>{{ subscriber.email }}</td>
                        <td>{{ subscriber.state }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-dark"
                                        @click='$router.push({ name: "subscriber.show", params: {"id":subscriber.id,data:subscriber} })'>
                                    Open
                                </button>
                                <button href="" class="btn btn-danger">Delete</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted} from "vue";
import {useFetch} from "../../composable/useFetch";

const {fetchData, data, isLoading, isRefreshing, error} = useFetch("/api/subscribers");

onMounted(fetchData)
</script>

