<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { ref } from 'vue';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';
import { ElNotification } from 'element-plus';

const { props } = usePage();
const services_id = props.services.id;

const resetForm = () => {
    form.value = {
        first_name: '',
    last_name: '',
    purposes: '',
    pick_up_date: '',
    reference_no: '',
    payment_type_id: '',
   }
    
}

const form = ref({
    first_name: '',
    last_name: '',
    purposes: '',
    pick_up_date: '',
    reference_no: '',
    payment_type_id: '',
    request_type_id: services_id,
});

const submit = async () => {
    console.log('Submitting form:', form.value);
    try {
        const response = await axios.post('/api/add/barangay/clearance', form.value);
        ElNotification({
            title: 'Success',
            message: 'Successfully added!',
            type: 'success',
            duration: 3000,
        });
    } catch (error) {
        let errorMessage = 'Failed to add';
        if (error.response && error.response.data) {
            errorMessage = error.response.data.message || 'Unknown error';
        }
        ElNotification({
            title: 'Error',
            message: errorMessage,
            type: 'error',
            duration: 3000,
        });
    }finally{
        resetForm();
    }
};

</script>

<template>
    <UserLayout>
        <section class="py-10">
            <div class="flex justify-center">
                <div class="justify-center border-2 w-96 grid cols-1">
                    <span class="flex justify-center font-bold">Barangay Health Certificates Payment</span>
                    <span class="flex justify-center">Gcash: 0998xxxxx</span>
                    <span class="flex justify-center">Payment fee: 100</span>
                </div>
            </div>
            <div class="border-2 w-full px-4 mt-8">
                <form class="mt-6" @submit.prevent="submit">
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First name</label>
                            <input type="text" id="first_name" v-model="form.first_name" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                        </div>
                        <div>
                            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last name</label>
                            <input type="text" id="last_name" v-model="form.last_name" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                        </div>
                        <div>
                            <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date Pick up</label>
                            <input type="date" id="date" v-model="form.pick_up_date" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                        </div>
                        <div>
                            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Payment Method</label>
                            <select id="countries" v-model="form.payment_type_id" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <option v-for="payment in props.payment_method" :key="payment.id" :value="payment.id">{{ payment.name }}</option>
                            </select>
                        </div>
                        <div>
                            <label for="reference_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reference #</label>
                            <input type="text" id="reference_no" v-model="form.reference_no" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                        </div>
                        <div>
                            <label for="purposes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purpose</label>
                            <textarea id="purposes" rows="4" v-model="form.purposes" required
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="mb-6 text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm w-64 px-8 py-2.5">Proceed</button>
                    </div>
                </form>
            </div>
        </section>
    </UserLayout>
</template>