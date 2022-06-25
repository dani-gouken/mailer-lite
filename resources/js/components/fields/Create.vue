<template>
    <div>
        <div class="row">
            <div class="col-12">
                <h2>
                    Create field
                </h2>
            </div>
            <div class="col-12">
                <div v-if="error && error.length !== 0" class="alert alert-danger" role="alert">
                    {{ error }}
                </div>
                <form @submit.prevent="onSubmit($event)">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <div class="input-group has-validation">
                            <input v-model="model.name" type="text" required :class='{"is-invalid":errors.name}'
                                   class="form-control"
                                   id="cs-name"
                                   placeholder="Enter name">
                            <div id="cs-name-err" v-if="error" v-for="e in (errors.name ?? [])" class="invalid-feedback">
                                {{ e }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input v-model="model.email" :class='{"is-invalid":errors.email}' name="email" type="email" required class="form-control"
                               id="cs-email" placeholder="Enter email">
                        <div id="cs-email-err" v-if="error" v-for="e in errors.email" class="invalid-feedback">
                            {{ e }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">State</label>
                        <select :class='{"is-invalid":errors.state}' v-model="model.state" name="state" class="form-select" required id="cs-state"
                                aria-label="Select state">
                            <option disabled selected>Select state</option>
                            <option value="active">Active</option>
                            <option value="unsubscribed">Unsubscribed</option>
                            <option value="bounced">Bounced</option>
                            <option value="unconfirmed">Unconfirmed</option>
                        </select>
                        <div id="cs-state-err" v-if="error" v-for="e in errors.state" class="invalid-feedback">
                            {{ e }}
                        </div>
                    </div>
                    <button :disabled="isOngoing" type="submit" class="btn btn-primary">
                        <span v-if="isOngoing">
                              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please wait...
                        </span>
                        <span v-else>
                            Submit
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {usePush} from "../../composable/usePush";

export default {
    data() {
        return {
            model: {
                name: "",
                email: "",
                state: ""
            }
        }
    },
    setup() {
        const {created: data, successful, isOngoing, pushData, errors, error} = usePush("/api/subscribers")
        return {
            data,
            successful,
            isOngoing,
            pushData,
            errors,
            error
        }
    },
    methods: {
        onSubmit() {
            console.log(this.model);
            this.pushData(this.model).then((success) => {
                if(success){
                    this.$router.push({name: "subscriber.index"})
                }
            })
        }
    }
}

</script>

