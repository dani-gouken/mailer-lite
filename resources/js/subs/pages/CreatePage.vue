<template>
  <div>
    <div class="row">
      <div class="col-12">
        <h2>Create subscriber</h2>
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
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useFetch } from "../../utils/useFetch";
import Form from "../components/Form.vue";
const model = ref({
  name: "",
  email: "",
  state: "",
});
const { isLoading, fetchData: create, errors, error } = useFetch();
const router = useRouter();
const onSubmit = () => {
  create({ url: "/api/subscribers", method: "POST", body: model.value }).then(
    () => router.push({ name: "subscriber.index", replace: true })
  );
};
</script>

