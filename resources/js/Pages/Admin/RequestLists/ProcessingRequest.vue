<script setup>
import { usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Delete, Edit } from '@element-plus/icons-vue';
import { ElButton, ElDialog, ElMessageBox, ElNotification, ElMessage } from 'element-plus';
import { initFlowbite } from 'flowbite';
import { watch, onMounted, onUnmounted, computed, ref } from 'vue';
import { debounce } from 'lodash';
import Pagination from '@/Components/Pagination.vue';
const { props } = usePage();
const editDialogVisible = ref(false);
const isLoading = ref(false);
const width = ref(window.innerWidth);
const message = ref('');
const search = ref('');
const selectedTypes = ref([]);
// const services_id = props.services.id;
// const transactions = ref({ data: [], links: {} });
const form = ref({
    id: null,
    status_id: '',
    // first_name: '',
    // last_name: '',
    // purposes: '',
    // pick_up_date: '',
    // reference_no: '',
    // payment_type_id: '',
    // request_type_id: services_id,
});

// watch(search, debounce(() => {
//     fetchTransactions(1)
// }, 300))


const transactions = ref([])
const pagination = ref({})
const loading = ref(false)

const fetchTransactions = async (page = 1) => {
    loading.value = true
    try {
        let res = await axios.get(`/api/processing/request?page=${page}`)
        transactions.value = res.data.data
        pagination.value = {
            current_page: res.data.current_page,
            last_page: res.data.last_page,
        }
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    fetchTransactions()
})

const deleteTransaction = async (id) => {
    const confirmDelete = await ElMessageBox.confirm(
        'Are you sure you want to delete this transactions?',
        'Warning',
        {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning',
        }
    ).catch(() => {
        ElMessage({
            type: 'info',
            message: 'Delete canceled',
        });
        return null; // Return null if canceled
    });

    if (!confirmDelete) return; // Exit if the user canceled

    isLoading.value = true;

    try {
        const response = await axios.delete(`/api/delete/request/${id}`);
        ElMessage({
            type: 'success',
            message: response.data.message,
        });
    } catch (error) {
        console.error(error);
        ElMessage({
            type: 'error',
            message: 'Something went wrong!',
        });
    } finally {
        isLoading.value = false;
    }

    await fetchTransactions();
}

const dialogWidth = computed(() => {
    return window.innerWidth < 640 ? '100%' : '680px'; // Adjust width based on screen size
});

const submitEditForm = async () => {
    console.log('submitted:', form.value)
    try {
        await updateTransaction();
        ElNotification({
            title: 'Success',
            message: 'Successfully updated!',
            type: 'success',
            duration: 3000,
        });
    } catch (error) {
        ElNotification({
            title: 'Error',
            message: 'Failed to update',
            type: 'error',
            duration: 3000,
        });

        if (error.response) {
            message.value = 'Error updating form: ' + (error.response.data.message || 'Unknown error');
        } else {
            message.value = 'Error updating form: ' + error.message;
        }
    } finally {
        // resetForm();
        editDialogVisible.value = false; // Close edit dialog
        await fetchTransactions(); // Refresh the transactions list
    }
};

const fetchTransactionForEdit = (status) => {
    form.value = {
        id: status.id,
        // first_name: status.first_name,
        // last_name: status.last_name,
        // purposes: status.purposes,
        // pick_up_date: status.pick_up_date,
        // reference_no: status.reference_no,
        // payment_type_id: status.payment_type_id,
        status_id: status.status_id
    };
    editDialogVisible.value = true; // Open edit modal
};


const submitForm = async () => {
    if (form.value.id) {
        await submitEditForm();
    } else {
        console.error("No ID provided for editing.");
    }
};


const updateTransaction = async () => {
    if (form.value.id) {
        await axios.put(`/api/update/request/lists/${form.value.id}`, form.value);
    }
    editDialogVisible.value = false; // Close edit dialog
    await fetchTransactions(); // Refresh the transactions list
};

const updateWidth = () => {
    width.value = window.innerWidth;
};


onMounted(() => {
    window.addEventListener('resize', updateWidth);
    fetchTransactions(); // existing code
    initFlowbite(); // existing code
});

onMounted(() => {
    fetchTransactions(); // Load transactions on component mount
    initFlowbite();
});

onUnmounted(() => {
    window.removeEventListener('resize', updateWidth);
});

// const updateTransaction = async () => {
//     if (form.value.id) {
//         await axios.put(`/api/update/transactions/${form.value.id}`, form.value);
//     }
//     editDialogVisible.value = false; // Close edit dialog
//     await fetchTransactions(); // Refresh the transactions list
// };





// const submitForm = async () => {
//     if (form.value.id) {
//         await submitEditForm();
//     } else {
//         await submitAddForm();
//     }
// };







// watch(editDialogVisible, (newValue) => {
//     if (!newValue) {
//         resetForm()
//     }
// });



</script>

<template>
    <AdminLayout>
        <section class=" p-3 sm:p-5">
            <div> <span class="text-2xl font-medium">Processing Lists </span></div>
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12 mt-10">
                <!-- Start coding here -->
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div
                        class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="simple-search" v-model="search"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Search" required="">
                                </div>
                            </form>
                        </div>
                        <div
                            class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                            <button type="button"
                                class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                Add product
                            </button>
                            <div class="flex items-center space-x-3 w-full md:w-auto">

                                <div id="actionsDropdown"
                                    class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="actionsDropdownButton">
                                        <li>
                                            <a href="#"
                                                class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass
                                                Edit</a>
                                        </li>
                                    </ul>
                                    <div class="py-1">
                                        <a href="#"
                                            class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete
                                            all</a>
                                    </div>
                                </div>
                                <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                                    class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                    type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                        class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Filter
                                    <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </button>
                                <div id="filterDropdown"
                                    class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                                    <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose brand</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="loading" class="px-4 mb-4">
                        <div role="status">
                            <svg aria-hidden="true"
                                class="w-8 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div v-else></div>
                    <div class="overflow-x-auto">

                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3"> No.</th>
                                    <th scope="col" class="px-4 py-3"> Name</th>
                                    <th scope="col" class="px-4 py-3">Pick up date</th>
                                    <th scope="col" class="px-4 py-3">Payment Method</th>
                                    <th scope="col" class="px-4 py-3">Reference No.</th>
                                    <th scope="col" class="px-4 py-3">Purpose</th>
                                    <th scope="col" class="px-4 py-3"> Date Requested</th>
                                    <th scope="col" class="px-4 py-3"> Status</th>
                                    <th scope="col" class="px-4 py-3"> Tracking Code</th>
                                    <th scope="col" class="px-4 py-3"> Action</th>
                                    <!-- <th scope="col" class="px-4 py-3">Brand</th>
                            <th scope="col" class="px-4 py-3">Description</th>
                            <th scope="col" class="px-4 py-3">Price</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b dark:border-gray-700" v-for="status in transactions"
                                    :key="status.id">
                                    <!-- <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">Apple iMac 27&#34;</th> -->
                                    <td class="px-4 py-3">{{ status.id }}</td>
                                    <td class="px-4 py-3">{{ status.first_name }}</td>
                                    <td class="px-4 py-3">{{ status.pick_up_date }}</td>
                                    <td class="px-4 py-3">{{ status.payment_type?.name }}</td>
                                    <td class="px-4 py-3">{{ status.reference_no }}</td>
                                    <td class="px-4 py-3">{{ status.purposes }}</td>
                                    <td class="px-4 py-3">{{ status.created_at }}</td>
                                    <td class="px-4 py-3">{{ status.status?.name }}</td>
                                    <td class="px-4 py-3">{{ status.tracking_code }}</td>
                                    <td class="px-4 py-3 flex items-center ">
                                        <el-button plain @click="fetchTransactionForEdit(status)" type="primary"
                                            :icon="Edit" />
                                        <el-button type="primary" @click="deleteTransaction(status.id)"
                                            :icon="Delete" />
                                    </td>
                                </tr>



                            </tbody>
                        </table>

                    </div>

                </div>


                <Pagination class="flex justify-center" :current-page="pagination.current_page || 1" :last-page="pagination.last_page || 1"
                    @page-change="fetchTransactions" />
            </div>

            <el-dialog v-model="editDialogVisible" :show="editDialogVisible" title="Edit Request"
                class="text-normal font-bold" :width="dialogWidth" draggable>
                <section class=" bg-white dark:bg-gray-900 p-3  antialiased">
                    <div>
                        <!-- <div class="flex justify-center p-3">
                            <img class="w-24"
                                src="https://logos-marques.com/wp-content/uploads/2023/05/GCash-Logo-thmb.png"
                                alt="GCash Logo" />
                        </div> -->
                        <div class="overflow-x-auto">
                            <form @submit.prevent="submitForm">
                                <div class="grid  mb-6 ">


                                    <div class="w-full">
                                        <label for="transaction"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                        <select id="transaction" v-model="form.status_id"
                                            class="mx-auto py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option>Select Status</option>
                                            <option v-for="status in props.status" :key="status.id" :value="status.id">
                                                {{ status.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-64 sm:w-auto px-10 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </el-dialog>
        </section>
    </AdminLayout>
</template>