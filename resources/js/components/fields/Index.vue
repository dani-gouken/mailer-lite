<template>
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <div v-if="isLoading" class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h3 class="me-auto ms-2">
                    Fields
                </h3>
                <div>
                    <button type="button" class="btn btn-primary">Add field</button>
                </div>
            </div>
            <div v-if="error">
                <div class="alert alert-danger">{{ error }}</div>
            </div>
        </div>
    </div>
</template>

<script>
import {useFetch} from "../../composable/useFetch";
import {onMounted} from "vue";
export default {
    props:{
        subscriberId: Number
    },
    setup({subscriberId}){
        const {data,fetchData, error, isLoading} = useFetch(`/api/subscribers/${subscriberId}/fields`)
        onMounted(fetchData)
        return {
            fields: data,
            isLoading,
            error
        }
    },

}
</script>
