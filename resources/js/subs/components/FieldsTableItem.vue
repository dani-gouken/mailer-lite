<template>
  <tr>
    <th scope="row">{{ subscriber.id }}</th>
    <td>{{ subscriber.name }}</td>
    <td>{{ subscriber.email }}</td>
    <td>{{ subscriber.state }}</td>
    <td>
      <div class="btn-group" role="group">
        <button
          :disabled="isLoading"
          class="btn btn-dark"
          @click="
            $router.push({
              name: 'subscriber.show',
              params: { subscriberId: subscriber.id },
            })
          "
        >
          Open
        </button>
        <button
          :disabled="isLoading"
          class="btn btn-danger"
          @click="onDeletePressed"
        >
          <Loader v-if="isLoading" />
          <span v-else>Delete</span>
        </button>
      </div>
    </td>
  </tr>
</template>
<script setup>
import { useFetch } from "../../utils/useFetch";
import Loader from "../../shared/Loader.vue";
const { subscriber } = defineProps({
  subscriber: {
    type: Object,
    required: true,
  },
});
const emit = defineEmits(["delete"]);
const { fetchData: deleteField, isLoading, error } = useFetch();

const onDeletePressed = () => {
  if (confirm("Are you sure")) {
    deleteField({
      url: `/api/subscribers/${subscriber.id}`,
      method: "DELETE",
    })
      .then(() => emit("delete"))
      .catch((err) => {
        console.error(err);
        alert(error.value);
      });
  }
};
</script>