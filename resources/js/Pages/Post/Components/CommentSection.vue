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
        <form @submit.prevent="addComment(e)" class="">
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
  export default {
    data() {
      return {
        comments: [
          { author: 'Người 1', content: 'Nội dung bình luận 1' },
          { author: 'Người 2', content: 'Nội dung bình luận 2' },
        ],
        newComment: '',
      };
    },
    methods: {
      addComment(e) {
        e.preventDefault();
            // let formData = new FormData();
            // formData.append('title', this.formPost.title);
            // formData.append('content', this.formPost.content);
            // formData.append('image', this.formPost.selectedImage);
            // try {
            //     const response = await axios.post('/post/create', formData);
            //     console.log(response.data);
            // } catch (error) {
            //     console.error(error);
            // }
        if (this.newComment.trim() !== '') {
          this.comments.push({ author: 'Bạn', content: this.newComment });
          this.newComment = '';
        }
      },
    },
  };
  </script>
  
  <style scoped>
  
  </style>
  