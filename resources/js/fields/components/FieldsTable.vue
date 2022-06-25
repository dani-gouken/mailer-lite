<template>
  <div class="row">
    <div class="col-12">
      <div class="d-flex align-items-center">
        <div v-if="isLoading" class="spinner-border" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <h3 class="me-auto ms-2">Fields</h3>
        <div>
          <button
            type="button"
            @click="
              $router.push({
                name: 'subscriber.field.create',
                params: { subscriberId: subscriber.id },
              })
            "
            class="btn btn-primary"
          >
            Add field
          </button>
        </div>
      </div>
      <div v-if="error">
        <div class="alert alert-danger">{{ error }}</div>
      </div>
    </div>
    <div class="col-12">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Type</th>
            <th scope="col">Options</th>
          </tr>
        </thead>
        <tbody>
          <table-item
            :key="field.id"
            @delete="load"
            :subscriber="subscriber"
            :field="field"
            v-for="field in fields"
          />
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { useFetch } from "../../utils/useFetch";
import TableItem from "./FieldsTableItem.vue";

import { onMounted, defineProps, ref } from "vue";
import { useRoute } from "vue-router";
const { subscriber } = defineProps({
  subscriber: {
    type: Object,
    required: true,
  },
});
const { data: fields, fetchData, error, isLoading } = useFetch();
const load = () =>
  fetchData({ url: `/api/subscribers/${subscriber.id}/fields` }).catch(
    console.error
  );

onMounted(() => load());
</script>
