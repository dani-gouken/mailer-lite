<template>
  <div>
    <div class="row">
      <div>
        <router-link
          :to="{
            name: 'subscriber.show',
            params: {
              subscriberId,
            },
          }"
          >Back to subscriber</router-link
        >
      </div>
      <div class="col-12">
        <div v-if="isLoading" class="spinner-border" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <h2>{{ subscriberId }} - Add field</h2>
      </div>
      <div class="col-12">
        <Form
          :model="model"
          :isLoading="isLoading"
          :validationErrors="errors"
          :errorMessage="error"
          @submit="onSubmit"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref, watch } from "@vue/runtime-core";
import { useRoute, useRouter } from "vue-router";
import { fieldTypes } from "../../constants";
import { useFetch } from "../../utils/useFetch";
import Form from "../components/Form.vue";

const model = ref({
  title: "",
  type: "",
});
const route = useRoute();
const router = useRouter();

const subscriberId = computed({
  get: () => route.params.subscriberId,
});

const url = computed({
  get: () => `/api/subscribers/${subscriberId.value}/fields`,
});
const { isLoading, fetchData: create, errors, error } = useFetch();
const onSubmit = () => {
  create({ url: url.value, model, method: "POST", body: model.value }).then(
    () => {
      router.push({
        name: "subscriber.show",
        params: { subscriberId: subscriberId.value },
        replace: true,
      });
    }
  );
};
</script>

