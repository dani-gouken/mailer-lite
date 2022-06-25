<template>
  <form @submit.prevent="onSubmit">
    <Alert :message="errorMessage" />
    <div class="mb-3">
      <label class="form-label">Name</label>
      <div class="input-group has-validation">
        <input
          v-model="model.name"
          type="text"
          required
          :class="{ 'is-invalid': validationErrors.name }"
          class="form-control"
          id="cs-name"
          placeholder="Enter name"
        />
        <div
          id="cs-name-err"
          :key="e"
          v-for="e in validationErrors.name ?? []"
          class="invalid-feedback"
        >
          {{ e }}
        </div>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input
        v-model="model.email"
        :class="{ 'is-invalid': validationErrors.email }"
        name="email"
        type="email"
        required
        class="form-control"
        id="cs-email"
        placeholder="Enter email"
      />
      <div
        id="cs-email-err"
        :key="e"
        v-for="e in validationErrors.email"
        class="invalid-feedback"
      >
        {{ e }}
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">State</label>
      <select
        :class="{ 'is-invalid': validationErrors.state }"
        v-model="model.state"
        name="state"
        class="form-select"
        required
        id="cs-state"
        aria-label="Select state"
      >
        <option disabled selected>Select state</option>
        <option :key="state" v-for="state in subscriberStates" :value="state">
          {{ state }}
        </option>
      </select>
      <div
        id="cs-state-err"
        :key="e"
        v-for="e in validationErrors.state"
        class="invalid-feedback"
      >
        {{ e }}
      </div>
    </div>
    <SubmitButton :isLoading="isLoading" />
  </form>
</template>

<script setup>
import { defineProps } from "vue";
import SubmitButton from "../../shared/SubmitButton.vue";
import Alert from "../../shared/Alert.vue";
import { subscriberStates } from "../../constants";

const emit = defineEmits(["submit"]);
const onSubmit = () => {
  emit("submit", model);
};
const { model, isLoading, validationErrors, errorMessage } = defineProps({
  errorMessage: String,
  validationErrors: {
    type: Object,
    default: {},
  },
  isLoading: Boolean,
  model: {
    required: true,
    type: Object,
  },
});
</script>