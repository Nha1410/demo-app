<template>
    <div class="comment-section">
      <div class="mt-4">
        <!-- Danh sách bình luận -->
        <div v-for="(comment, index) in comments" :key="index" class="mb-4">
          <div class="flex items-center mb-2">
            <div class="h-8 w-8 rounded-full bg-gray-400"></div>
            <span class="ml-2 font-semibold">{{ comment.author }}</span>
            <span class="ml-2 font-light text-[13px]">6 minutes ago</span>
          </div>
          <p class="text-gray-700">{{ comment.content }}</p>
        </div>
      </div>
  
      <!-- Form bình luận -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Thêm bình luận mới</h3>
        <form @submit.prevent="addComment($event)" class="">
          <resize-textarea 
            v-model="newComment" 
            class="w-full p-2 border rounded"
            type="comment"
            id="content"
            :rows = 1
          >
          </resize-textarea>
          <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Bình luận</button>
        </form>
      </div>
    </div>
</template>
  
  <script>
import axios from 'axios';

  export default {
    data() {
      return {
        comments: [
          { author: 'Người 1', content: 'Nội dung bình luận 1' },
          { author: 'Người 2', content: 'Nội dung bình luận 2' },
        ],
        newComment: '',
        formPost: {
          content: '',
          selectedImage: '',
        }
      };
    },
    props: {
      postId: {
        type: Number,
        default: '',
      },
      commentPostRoute: {
        type: String,
        default: '',
      }
    },
    methods: {
      addComment(e) {
        e.preventDefault();
          console.log(this);
          console.log(this.commentPostRoute);
          let formData = new FormData();
            formData.append('content', this.formPost.content);
            formData.append('image', this.formPost.selectedImage);
            axios
              .post(this.commentPostRoute, formData)
              .then((res) => console.log(res))
              .finally(() => {
                  if (this.newComment.trim() !== '') {
                    this.comments.push({ author: 'Bạn', content: this.newComment });
                    this.newComment = '';
                  }
                }
              )
      },
    },
  };
  </script>
  
  <style scoped>
  
  </style>
  