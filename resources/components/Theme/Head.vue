<script setup>
import { Head as InertiaHead } from '@inertiajs/vue3'

defineOptions({
  name: 'ThemeHead',
})


const props = withDefaults(defineProps(), {
  item: () => ({}),
  title: '',
  description: '',
})

const appName = 'My Application'

const title =
  props.item && props.item.meta_title && props.item.meta_title != ''
    ? props.item.meta_title
    : props.item && props.item.title && props.item.title != ''
    ? props.item.title
    : props.title

const description =
  props.item && props.item.meta_description && props.item.meta_description != ''
    ? props.item.meta_description
    : props.item && props.item.description && props.item.description != ''
    ? props.item.description
    : props.description
</script>

<template>
  <InertiaHead :title="title ? `${title} | ${appName}` : appName">
    <template v-if="description !== ''">
      <meta
        head-key="description"
        name="description"
        :content="description"
      />
    </template>
  </InertiaHead>
</template>
