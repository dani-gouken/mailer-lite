<template>
  <div>
    <div class="row">
      <div class="col-12">
        <h2>
          Edit field<span v-if="original.id">: {{ original.title }}</span>
        </h2>
      </div>
      <div class="col-12">
        <Alert :message="error" />
        <Form
          v-if="original.id"
          :model="model"
          :isLoading="isLoading"
          :validationErrors="editErrors"
          :errorMessage="editError"
          @submit="onSubmit"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { fieldTypes } from "../../constants";

import { watch, onMounted, computed, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useFetch } from "../../utils/useFetch";
import Form from "../components/Form.vue";
import Alert from "../../shared/Alert.vue";

const { data: original, isLoading, error: loadingError, fetchData } = useFetch({});
const route = useRoute();
const model = ref({});
const router = useRouter();
const url = computed({
  get: () =>
    `/api/subscribers/${route.params.subscriberId}/fields/${route.params.fieldId}`,
});

const {
  isLoading: isUpdating,
  error: editError,
  fetchData: editField,
  errors: editErrors,
} = useFetch();

const error = computed({
  get: () => editError.value || loadingError.value,
});

watch(
  url,
  () => {
    if (!route.params.fieldId) {
      return;
    }
    model.value = {};
    fetchData({ url: url.value, method: "GET", defaultData: {} }).then((v) => {
      model.value = { ...v };
    });
  },
  {
    immediate: true,
  }
);

const isWorking = computed(() => {
  get: () => {
    return isLoading || isUpdating;
  };
});

const onSubmit = () => {
  editField({ url: url.value, body: model.value, method: "PUT" }).then(
    (success) => {
      router.push({
        name: "subscriber.show",
        params: {
          subscriberId: route.params.subscriberId,
        },
        replace: true,
      });
    }
  );
};
</script>

