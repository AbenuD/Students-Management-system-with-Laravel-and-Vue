// auth.js
import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore({
  id: 'auth',
  state: () => ({
    isAuthenticated: false,
    user: null,
    role: null,
    error: null,
  }),
  actions: {
    async login(email, password) {
      try {
        const response = await axios.post('/api/login', { email, password });
        const { user, roles } = response.data;
        
        this.isAuthenticated = true;
        this.user = user;
        if (roles.includes('student')) {
          this.role = 'student';
        } else if (roles.includes('teacher')) {
          if(roles.includes('dep_head')){
            this.role = 'dep_head'
          }
          else if(roles.includes('advisor')){
            this.role = 'advisor'
          }
          else this.role = 'teacher';
        } else if (roles.includes('admin')) {
          this.role = 'admin';
        } else if (roles.includes('dep_head')) {
          this.role = 'dep_head';
        } 
        else {
          this.role = null;
        }

        this.error = null;
      } catch (error) {
        console.error(error);
        if (error.response && error.response.data && error.response.data.errors) {
          this.error = error.response.data.errors;
        } else {
          this.error = 'An error occurred while processing your request.';
        }
        throw new Error('Login failed');
      }
    },
    logout() {
      this.isAuthenticated = false;
      this.user = null;
      this.role = null;
      this.error = null;
    },
  },
  getters: {
    isLoggedIn() {
      return this.isAuthenticated;
    },
    getUser() {
      return this.user;
    },
    getRole() {
      return this.role;
    },
    getError() {
      return this.error;
    },
  },
});
