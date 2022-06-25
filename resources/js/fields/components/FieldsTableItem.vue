<template>
  <tr>
    <th scope="row">{{ field.id }}</th>
    <td>{{ field.title }}</td>
    <td>{{ field.type }}</td>
    <td>
      <div class="btn-group" role="group">
        <button
          @click="onEditPressed"
          class="btn btn-dark"
          :disabled="isLoading"
        >
          Edit
        </button>
        <button
          @click="onDeletePressed"
          class="btn btn-danger"
          :disabled="isLoading"
        >
          <span
            v-if="isLoading"
            class="spinner-border spinner-border-sm"
            role="status"
            aria-hidden="true"
          ></span>
          <span v-else>Delete</span>
        </button>
      </div>
    </td>
  </tr>
</template>
<script setup>
import { useFetch } from "../../utils/useFetch";
import { defineProps, defineEmits } from "vue";
import { useRouter } from "vue-router";

const { field, subscriber } = defineProps({
  field: {
    type: Object,
    required: true,
  },
  subscriber: {
    type: Object,
    required: true,
  },
});
const router = useRouter();
const emit = defineEmits(["delete"]);
const { fetchData: deleteField, isLoading, error } = useFetch();
const onEditPressed = () => {
  router.push({
    name: "subscriber.field.edit",
    params: {
      subscriberId: subscriber.id,
      fieldId: field.id,
    },
  });
};
const onDeletePressed = () => {
  if (confirm("Are you sure")) {
    deleteField({
      url: `/api/subscribers/${subscriber.id}/fields/${field.id}`,
      method: "DELETE",
    })
      .then(() => emit("delete"))
      .catch((err) => {
        console.error(err);
        alert(error.value)
      });
  }
};
</script>