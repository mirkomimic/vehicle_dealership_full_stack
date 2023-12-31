<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { watch, computed, toRefs, ref, nextTick } from 'vue';
// import { VDataTable } from 'vuetify/labs/VDataTable'

const props = defineProps(['brands', 'breadcrumbs'])
const { brands } = toRefs(props)

const rules = {
  required: value => !!value || 'The name field is required.',
}

const formTable = useForm({
  id: null,
  name: null,
  image: null,
})

// data table
const headers = [
  { title: 'ID', key: 'id' },
  { title: 'Name', key: 'name' },
  { title: 'Image', key: 'image', align: 'center' },
  { title: 'Actions', key: 'actions', sortable: false }
]
const dialogTable = ref(false)
const dialogDelete = ref(false)
const editedIndex = ref(-1)
const search = ref('')
const progressTextInput = ref(false)
const editedItem = ref({
  id: null,
  name: '',
  image: null
})
const defaultItem = ref({
  id: null,
  name: '',
  image: null
})

const formTitle = computed(() => {
  return editedIndex.value === -1 ? 'New Brand' : 'Edit Brand'
})

watch(dialogTable, (val) => {
  val || close()
})
watch(dialogDelete, (val) => {
  val || closeDelete()
})

const editItem = (item) => {
  formTable.id = item.id
  formTable.name = item.name

  editedIndex.value = brands.value.indexOf(item)
  editedItem.value = Object.assign({}, item)
  dialogTable.value = true
}
const deleteItem = (item) => {
  editedIndex.value = brands.value.indexOf(item)
  editedItem.value = Object.assign({}, item)
  dialogDelete.value = true
}
const deleteItemConfirm = () => {
  // delete brand
  try {
    router.delete(route('dashboard.brands.delete', editedItem.value.id))
    
    setTimeout(() => {
      document.getElementById('successMsg').style.display = 'none'
      usePage().props.flash.success = null
    }, 3000);

  } catch (error) {
    console.log(error);
  }

  closeDelete()
}
const close = () => {
  dialogTable.value = false
  nextTick(() => {
    editedItem.value = Object.assign({}, defaultItem.value)
    editedIndex.value = -1
    usePage().props.errors.name = null
    formTable.reset();
    brandImgPreview.value = null
  })
}
const closeDelete = () => {
  dialogDelete.value = false
  nextTick(() => {
    editedItem.value = Object.assign({}, defaultItem.value)
    editedIndex.value = -1
  })
}
const save = () => {
  if (editedIndex.value > -1) {
   
    // edit brand
    try {

      formTable.post(route('dashboard.brands.update', formTable.id), {
        _method: 'put'
      });

      formTable.reset()

      progressTextInput.value = true

      setTimeout(() => {
        progressTextInput.value = false
        close()

      }, 2000)

      setTimeout(() => {
        document.getElementById('successMsg').style.display = 'none'
        usePage().props.flash.success = null

      }, 5000);

      
    } catch (error) {
      console.log(error);
    }
  } else {
    // add brand
    try {
      formTable.post(route('dashboard.brands.store'));
      formTable.reset()

      progressTextInput.value = true

      setTimeout(() => {
        progressTextInput.value = false
        close()

      }, 2000)

      setTimeout(() => {
        document.getElementById('successMsg').style.display = 'none'
        usePage().props.flash.success = null

      }, 5000);
    
    } catch (error) {
      console.log(error);
    }
  }
}

const brandImgPreview = ref(null)

const setImg = (e) => {
  formTable.image = e.target.files[0]
  brandImgPreview.value = URL.createObjectURL(e.target.files[0])
}
</script>

<template>
  <Head title="Dashboard | Brands" />

  <DashboardLayout>

    <!-- alert -->
    <div style="width: 300px;">        
      <v-snackbar
        v-model="$page.props.flash.success"
        location="top right"
        position="fixed"
        timeout="5000"
        variant="elevated"
        color="rgba(33,250,182,0.7)"
        vertical
      >
        <div class="text-subtitle-1 pb-2 font-weight-bold">Message</div>

        <p>{{ $page.props.flash.success }}</p>

        <template v-slot:actions>
          <v-btn
            color="black"
            variant="text"
            @click="$page.props.flash.success = false"
          >
            Close
          </v-btn>
        </template>
      </v-snackbar>

    </div>

    <v-container fluid class="pa-0 ma-0 ps-lg-10">
      <v-breadcrumbs
        :items="breadcrumbs"
        divider="/"
        icon="mdi-shield-account"
      >
        <template v-slot:item="{item}">
          <v-breadcrumbs-item :disabled="item.disabled">
            <Link :href="route(item.href)">{{ item.title }}</Link>
          </v-breadcrumbs-item>
        </template>
      </v-breadcrumbs>
    </v-container>


    <div class="text-h4 text-teal-darken-1 text-uppercase text-center mt-5">Brands</div>

    <!-- data table -->
    <div>
      <div class="mx-auto mt-10 mb-3 pa-1 mm-border-green rounded-sm" style="width: 1000px;">
      
        <v-data-table
          :headers="headers"
          :items="brands"
          :search="search"
        >
          <template v-slot:top>
            <v-toolbar
              flat
            >
              <v-toolbar-title>
                <template v-slot:text>
                  <v-text-field
                    v-model="search"
                    label="Search"
                    prepend-inner-icon="mdi-magnify"
                    single-line
                    variant="outlined"
                    hide-details
                    class="vuetifyInput"
                  ></v-text-field>
                </template>
              </v-toolbar-title>
              <v-spacer></v-spacer>
              <v-dialog
                v-model="dialogTable"
                max-width="500px"
              >
                <template v-slot:activator="{ props }">
                  <v-btn
                    color="teal-lighten-3"
                    dark
                    variant="outlined"
                    class=""
                    v-bind="props"
                  >
                    New Brand
                  </v-btn>
                </template>
                <v-card>

                  <v-progress-linear
                    :active="progressTextInput"
                    color="teal-darken-3"
                    height="7"
                    indeterminate
                  ></v-progress-linear>

                  <v-card-title>
                    <span class="text-h5 text-teal-lighten-3">{{ formTitle }}</span>
                  </v-card-title>
                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col
                          cols="12"
                        >
                          <v-text-field
                            v-model="formTable.name"
                            :rules="[rules.required]"
                            :error-messages="$page.props.errors.name"
                            label="Name"
                            class="vuetifyInput"
                          >
                          </v-text-field>
                        </v-col>
                        <v-col
                          cols="12"
                        >
                          <v-file-input
                            @change="setImg"
                            label="Add Image"
                            variant="filled"
                            prepend-icon="mdi-camera"
                          ></v-file-input>
                        </v-col>
                        <v-col
                          cols="12"
                        >
                          <v-sheet class="d-flex justify-center">
                            <v-img v-if="brandImgPreview" :src="brandImgPreview" width="100" height="100"></v-img>
                            <v-sheet v-else border="sm" rounded class="d-flex justify-center items-center pa-2" width="200" height="100">
                              <v-icon icon="mdi-image-frame" size="50" class="mt-3" color="teal-lighten-3"></v-icon>
                            </v-sheet>
                          </v-sheet>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                      color="teal-lighten-3"
                      variant="text"
                      @click="close"
                    >
                      Cancel
                    </v-btn>
                    <v-btn
                      color="teal-lighten-3"
                      variant="text"
                      @click="save"
                    >
                      Save
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                  <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue-darken-1" variant="text" @click="closeDelete">Cancel</v-btn>
                    <v-btn color="blue-darken-1" variant="text" @click="deleteItemConfirm">OK</v-btn>
                    <v-spacer></v-spacer>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>
          <template v-slot:item.image="{ item }">
            <div>
              <v-img :src="'/storage/images/brands/'+item.image" :alt="item.name" height="40px"></v-img>
            </div>
          </template>
          <template v-slot:item.actions="{ item }">
            <v-icon
              size="small"
              class="me-2"
              @click="editItem(item)"
              icon="mdi-pencil"
              color="blue-darken-1"
            >
              mdi-pencil
            </v-icon>
            <v-icon
              size="small"
              @click="deleteItem(item)"
              icon="mdi-delete"
              color="red-lighten-2"
            >
              mdi-delete
            </v-icon>
          </template>
        </v-data-table>
      </div>
    </div>
    
  </DashboardLayout>
</template>

<style scoped>
.vuetifyInput:deep() input {
  background-color: transparent !important;
  box-shadow: none;
}
</style>