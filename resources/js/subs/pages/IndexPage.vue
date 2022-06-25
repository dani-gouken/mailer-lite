<template>
  <div>
    <div class="row">
      <div class="col-12">
        <div class="d-flex align-items-center">
          <Loader v-if="isLoading" />
          <h2 class="me-auto ms-2">Subscribers</h2>
          <p>
            <router-link tag="button" :to="{ name: 'subscriber.create' }">
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
            <FieldsTableItem
              v-for="subscriber in data"
              @delete="load"
              :subscriber="subscriber"
              :key="subscriber.id"
            />
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, watch } from "vue";
import { useFetch } from "../../utils/useFetch";
import Loader from "../../shared/Loader.vue";
import FieldsTableItem from "../components/FieldsTableItem.vue";

const { fetchData, data, isLoading, error } = useFetch();
const load = () => fetchData({ url: "/api/subscribers" });
onMounted(() => load());
</script>

