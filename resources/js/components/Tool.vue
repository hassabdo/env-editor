<template>
    <loading-view :loading="loading">
        <heading class="mb-3">{{ __('Edit Environment File') }}</heading>
        <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 mb-3" role="alert">
            <p class="font-bold">{{__('Caution')}}</p>
            <p>{{__('Be careful when modifying, it may affect existing integrations.')}}</p>
        </div>
        <card class="overflow-hidden">
            <form @submit.prevent="saveFile">
                <!-- Validation Errors -->
                <validation-errors :errors="validationErrors" />

                <!-- Fields -->
                <div v-for="field in fields">
                    <component :is="'form-' + field.component" :field="field" />
                </div>

                <!-- Create Button -->
                <div class="bg-30 flex px-8 py-4">
                    <button
                        dusk="create-and-add-another-button"
                        class="ml-auto btn btn-default btn-primary mr-3"
                    >
                        {{ __('Save File') }}
                    </button>
                </div>
            </form>
        </card>
    </loading-view>
</template>

<script>
import { Errors, Minimum } from 'laravel-nova';

export default {
    data: () => ({
        loading: true,
        fields: [],
        validationErrors: new Errors(),
    }),

    created() {
        this.getFields();
    },
    methods: {
        /**
         * Get the available fields for the resource.
         */
        async getFields() {
            this.fields = [];

            const { data: fields } = await Nova.request().get(
                '/nova-vendor/hassen/env-editor/environment'
            );
            this.fields = fields;
            this.loading = false;
        },

        /**
         * Saves the user's profile
         */
        async saveFile() {
            try {
                this.loading = true;
                const response = await this.createRequest();
                this.loading = false;

                this.$toasted.show(this.__('Your env file has been saved!'), { type: 'success' });

                // Reset the form by refetching the fields
                this.getFields();

                this.validationErrors = new Errors();
            } catch (error) {
                this.loading = false;
                if (error.response.status == 422) {
                    this.validationErrors = new Errors(error.response.data.errors);
                    console.log(this.validationErrors);
                }
            }
        },

        /**
         * Send a create request to update the user's profile data
         */
        createRequest() {
            return Nova.request().post(
                '/nova-vendor/hassen/env-editor/environment',
                this.createResourceFormData()
            );
        },

        /**
         * Create the form data for creating the resource.
         */
        createResourceFormData() {
            return _.tap(new FormData(), (formData) => {
                _.each(this.fields, (field) => {
                    field.fill(formData);
                });
            });
        },
    },
};
</script>
