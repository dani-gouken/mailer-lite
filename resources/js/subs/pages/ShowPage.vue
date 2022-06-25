<template>
  <div class="col-12">
    <div>
      <router-link :to="{ name: 'subscriber.index' }"> Index </router-link>
    </div>
    <div class="d-flex align-items-center">
      <div v-if="isLoading" class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <h2 class="me-auto ms-2">
        {{ subscriber.name }}
      </h2>
    </div>
    <div v-if="subscriber.id">
      <button
        class="btn btn-primary"
        @click="
          $router.push({
            name: 'subscriber.edit',
            params: { subscriberId: subscriber.id },
          })
        "
      >
        Edit
      </button>
    </div>
    <div v-if="error" class="alert alert-danger">
      {{ error }}
    </div>
  </div>

  <div class="col-12">
    <table class="table" v-if="subscriber.id">
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
    <FieldsTable :subscriber="subscriber" />
  </div>
</template>
<script setup>
import FieldsTable from "../../fields/components/FieldsTable";
import { watch } from "vue";
import { useRoute } from "vue-router";
import { useFetch } from "../../utils/useFetch";

const route = useRoute();
const { isLoading, fetchData, data: subscriber, error } = useFetch();
watch(
  route,
  (v) => {
    if(!route.params.subscriberId){
      return;
    }
    fetchData({
      url: `api/subscribers/${v.params.subscriberId}`,
      method: "GET",
      defaultData: {},
    }).catch(console.error);
  },
  {
    immediate: true,
  }
);
</script>
