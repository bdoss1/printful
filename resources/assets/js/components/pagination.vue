<template>
  <nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">
    <a class="pagination-previous" :disabled="pagination.current_page <= 1" @click.prevent="changePage(1)">First Page</a>
    <a class="pagination-previous" :disabled="pagination.current_page <= 1" @click.prevent="changePage(pagination.current_page - 1)">Previous Page</a>
    <a class="pagination-next" :disabled="pagination.current_page >= pagination.last_page" @click.prevent="changePage(pagination.current_page + 1)">Next Page</a>
    <a class="pagination-next" :disabled="pagination.current_page >= pagination.last_page" @click.prevent="changePage(pagination.last_page)">Last Page</a>
    <ul class="pagination-list">
      <li v-for="(page, index) in pages" :key="index">
        <a class="pagination-link" :class="isCurrentPage(page) ? 'is-current' : ''" @click.prevent="changePage(page)">{{ page }}</a>
      </li>
    </ul>
  </nav>
</template>

<style scoped>
.pagination {
    margin-top: 40px;
}
.delete, .modal-close, .is-unselectable, .button, .file, .breadcrumb, .pagination-previous,
.pagination-next,
.pagination-link,
.pagination-ellipsis, .tabs {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.button, .input,
.textarea, .select select, .file-cta,
.file-name, .pagination-previous,
.pagination-next,
.pagination-link,
.pagination-ellipsis {
    -moz-appearance: none;
    -webkit-appearance: none;
    align-items: center;
    border: 1px solid transparent;
    border-radius: 4px;
    box-shadow: none;
    display: inline-flex;
    font-size: 1rem;
    height: 2.25em;
    justify-content: flex-start;
    line-height: 1.5;
    padding-bottom: calc(0.375em - 1px);
    padding-left: calc(0.625em - 1px);
    padding-right: calc(0.625em - 1px);
    padding-top: calc(0.375em - 1px);
    position: relative;
    vertical-align: top;
}

.button:focus, .input:focus,
.textarea:focus, .select select:focus, .file-cta:focus,
.file-name:focus, .pagination-previous:focus,
.pagination-next:focus,
.pagination-link:focus,
.pagination-ellipsis:focus, .is-focused.button, .is-focused.input,
.is-focused.textarea, .select select.is-focused, .is-focused.file-cta,
.is-focused.file-name, .is-focused.pagination-previous,
.is-focused.pagination-next,
.is-focused.pagination-link,
.is-focused.pagination-ellipsis, .button:active, .input:active,
.textarea:active, .select select:active, .file-cta:active,
.file-name:active, .pagination-previous:active,
.pagination-next:active,
.pagination-link:active,
.pagination-ellipsis:active, .is-active.button, .is-active.input,
.is-active.textarea, .select select.is-active, .is-active.file-cta,
.is-active.file-name, .is-active.pagination-previous,
.is-active.pagination-next,
.is-active.pagination-link,
.is-active.pagination-ellipsis {
    outline: none;
}

.button[disabled], .input[disabled],
.textarea[disabled], .select select[disabled], .file-cta[disabled],
.file-name[disabled], .pagination-previous[disabled],
.pagination-next[disabled],
.pagination-link[disabled],
.pagination-ellipsis[disabled] {
    cursor: not-allowed;
}

.pagination {
    margin: -0.25rem;
}

.pagination.is-small {
    font-size: 0.75rem;
}

.pagination.is-medium {
    font-size: 1.25rem;
}

.pagination.is-large {
    font-size: 1.5rem;
}

.pagination.is-rounded .pagination-previous,
.pagination.is-rounded .pagination-next {
    padding-left: 1em;
    padding-right: 1em;
    border-radius: 290486px;
}

.pagination.is-rounded .pagination-link {
    border-radius: 290486px;
}

.pagination,
.pagination-list {
    align-items: center;
    display: flex;
    justify-content: center;
    text-align: center;
}

.pagination-previous,
.pagination-next,
.pagination-link,
.pagination-ellipsis {
    font-size: 1em;
    padding-left: 0.5em;
    padding-right: 0.5em;
    justify-content: center;
    margin: 0.25rem;
    text-align: center;
}

.pagination-previous,
.pagination-next,
.pagination-link {
    border-color: #dbdbdb;
    color: #363636;
    min-width: 2.25em;
}

.pagination-previous:hover,
.pagination-next:hover,
.pagination-link:hover {
    border-color: #b5b5b5;
    color: #363636;
}

.pagination-previous:focus,
.pagination-next:focus,
.pagination-link:focus {
    border-color: #3273dc;
}

.pagination-previous:active,
.pagination-next:active,
.pagination-link:active {
    box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.2);
}

.pagination-previous[disabled],
.pagination-next[disabled],
.pagination-link[disabled] {
    background-color: #dbdbdb;
    border-color: #dbdbdb;
    box-shadow: none;
    color: #7a7a7a;
    opacity: 0.5;
}

.pagination-previous,
.pagination-next {
    padding-left: 0.75em;
    padding-right: 0.75em;
    white-space: nowrap;
}

.pagination-link.is-current {
    background-color: #3273dc;
    border-color: #3273dc;
    color: #fff;
}

.pagination-ellipsis {
    color: #b5b5b5;
    pointer-events: none;
}

.pagination-list {
    flex-wrap: wrap;
}

@media screen and (max-width: 768px) {
    .pagination {
        flex-wrap: wrap;
    }
    .pagination-previous,
    .pagination-next {
        flex-grow: 1;
        flex-shrink: 1;
    }
    .pagination-list li {
        flex-grow: 1;
        flex-shrink: 1;
    }
}

@media screen and (min-width: 769px), print {
    .pagination-list {
        flex-grow: 1;
        flex-shrink: 1;
        justify-content: flex-start;
        order: 1;
    }
    .pagination-previous {
        order: 2;
    }
    .pagination-next {
        order: 3;
    }
    .pagination {
        justify-content: space-between;
    }
    .pagination.is-centered .pagination-previous {
        order: 1;
    }
    .pagination.is-centered .pagination-list {
        justify-content: center;
        order: 2;
        list-style: none;
    }
    .pagination.is-centered .pagination-next {
        order: 3;
    }
    .pagination.is-right .pagination-previous {
        order: 1;
    }
    .pagination.is-right .pagination-next {
        order: 2;
    }
    .pagination.is-right .pagination-list {
        justify-content: flex-end;
        order: 3;
    }
}
</style>

<script>
export default {
  props: {
    pagination: {
      type: Object,
      default: null,
      required: true
    },
    offset: {
      type: Number,
      default: 1,
      required: true
    }
  },
  computed: {
    pages() {
      const pages = []
      let from = this.pagination.current_page - Math.floor(this.offset / 2)
      if (from < 1) {
        from = 1
      }
      let to = from + this.offset - 1
      if (to > this.pagination.last_page) {
        to = this.pagination.last_page
      }
      while (from <= to) {
        pages.push(from)
        from++
      }
      return pages
    }
  },
  methods: {
    isCurrentPage(page) {
      return this.pagination.current_page === page
    },
    changePage(page) {
      if (page > this.pagination.last_page) {
        page = this.pagination.last_page
      }
      this.pagination.current_page = page
      this.$emit('paginate')
    }
  }
}
</script>
