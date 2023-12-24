<template>
  <div class="border-s-sm ps-2">
    <v-card
      min-height="100"
      rounded="lg"
      class="d-flex pa-2 me-3"
      border
      :class="{'mm-border-green': user.id == comment.user_id}"
    >
      <v-row>
        <v-col 
          cols="12"
          md="3"
          class="d-flex flex-row flex-md-column pb-0 pb-md-2"
        >
          <div class="d-flex">
            <div>
              <img width="30" src="/user-placeholder.png" class="rounded-circle mt-2"/>
            </div>
            <div class="ms-2 text-subtitle-2">
              <div class="text-teal-accent-2">{{ comment.user.name }}</div>
              <div class="text-grey-lighten-1">{{ moment(comment.created_at).startOf('minute').fromNow() }}</div>
            </div>
          </div>

          <div class="ms-auto ms-md-0 mt-md-auto">
            <!-- likes -->
          </div>
        </v-col>

        <v-divider class="my-3" vertical></v-divider>

        <v-col 
          cols="12"
          md="9"
          class="d-flex flex-column pt-0 pt-md-2"
        >
          <div class="text-grey-lighten-3" style="min-height: 50px;">
            {{ comment.comment }}
          </div>
          <div class="mt-auto d-flex align-end">

            <div>
              <ReplyDialog :comment="comment"/>
            </div>

            <div>
              <v-btn
                v-if="comment.replies.length"
                @click="collapse = !collapse"
                color="teal-lighten-3"
                variant="text"
                prepend-icon="mdi-chevron-down"
                density="compact"
                style="width: 170px;"
              >
                {{ collapse ? 'Collapse' : 'Show' }}
                <!-- <template v-slot:append>
                  ({{ comment.replies.length ? comment.replies.length : '' }})
                </template> -->
              </v-btn>
            </div>

            <div class="ms-auto">
              <v-menu>
                <template v-slot:activator="{ props }">
                  <v-btn
                    icon="mdi-dots-vertical"
                    variant="text"
                    v-bind="props"
                    density="compact"
                  >
                  </v-btn>
                </template>
                <v-list density="compact" rounded="lg">
                  <div
                    v-for="(item, index) in menuItems"
                    :key="index"
                  >
                    <v-list-item
                      v-if="item.isAuthorized(comment.user_id)"
                      :value="index"
                      @click="edit(comment.id)"
                      :class="item.color"
                    >
                      <template v-slot:prepend>
                        <v-icon :icon="item.icon" class="me-n5"/>
                      </template>
                      <v-list-item-title>
                        {{ item.title }}
                      </v-list-item-title>
                    </v-list-item>
                  </div>
                </v-list>
              </v-menu>
            </div>
          </div>
        </v-col>
      </v-row>
    </v-card>

    <div class="ms-2 mt-3" style="overflow: hidden;">
      <Transition name="list">
        <div v-if="collapse">
          <Comments
            v-for="reply in comment.replies"
            :key="reply"
            :comment="reply"
          />
        </div>
      </Transition>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import ReplyDialog from '../Dialogs/ReplyDialog.vue';
import moment from "moment";
import { usePage } from '@inertiajs/vue3';

const props = defineProps(['comment'])
const user = usePage().props.auth.user

const collapse = ref(true)

const menuItems = [
  {
    icon: 'mdi-pencil-box-outline',
    title: 'Edit',
    color: 'text-teal-accent-1',
    isAuthorized: (user_id) => user_id == user.id || user.is_admin
  },
  {
    icon: 'mdi-exclamation-thick',
    title: 'Report',
    color: 'text-yellow-darken-2',
    isAuthorized: (user_id) => user != null
  },
  {
    icon: 'mdi-trash-can-outline',
    title: 'Delete',
    color: 'text-red-darken-2',
    isAuthorized: (user_id) => user_id == user.id || user.is_admin
  },
]

const edit = (id) => {
  console.log(id);
}
</script>

<style>
.list-enter-active,
.list-leave-active {
  transition: all .5s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateY(-30px);
}
</style>
