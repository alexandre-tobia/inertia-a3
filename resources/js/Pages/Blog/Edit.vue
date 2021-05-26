<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edition d'un article
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <form @submit.prevent="update">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="name" value="Name"/>
                                <jet-input id="name" type="name" class="mt-1 block w-full" v-model="form.name"
                                           ref="name" autocomplete="name"/>
                                <jet-input-error :message="form.errors.name" class="mt-2"/>
                                <jet-input-error :message="form.errors.slug" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="content" value="Contenu"/>
                                <textarea class="mt-1 block w-full" name="content" cols="10" rows="10"
                                          v-model="form.content"></textarea>
                                <jet-input-error :message="form.errors.content" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="published" value="Publié ?"/>
                                <input id="published" type="checkbox" name="published" v-model="form.published">
                            </div>
                        </div>

                        <jet-button :class="{ 'opacity-25': form.processing }" class="mt-5" :disabled="form.processing">
                            Sauvegarder
                        </jet-button>
                    </form>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetButton from '@/Jetstream/Button'

export default {
    props: ['post', 'errors'],
    components: {
        AppLayout,
        JetInput,
        JetInputError,
        JetLabel,
        JetButton
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.post.name,
                content: this.post.content,
                published: this.post.published
            })
        }
    },

    methods: {
        update() {
            this.form.put(this.route('blog.update', [this.post.id]), this.form);
        }
    }
}
</script>
