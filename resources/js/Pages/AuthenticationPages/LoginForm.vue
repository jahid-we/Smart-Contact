<script setup>
import FeaturesComp from "../../Components/FeaturesComp.vue";
import ContactComp from "../../Components/ContactComp.vue";
import FooterComp from "../../Components/FooterComp.vue";
import { successToast, errorToast } from '@/utils/toast';
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import axios from "axios";


const email = ref('');
const loading = ref(false); // Controls the loading state

// Send OTP Functionality

const sendOTP = async () =>{
    // Trim email input to remove extra spaces and check if empty
    if (!email.value.trim()) {
        errorToast("Please enter your email");
        return;
    };
    loading.value = true; // Set loading state to prevent multiple clicks
    try{
        let res=await axios.post("/api/auth/login",{
            email:email.value
        });
        if(res.data.status===true){
            localStorage.setItem("email", email.value); // Store email in local storage
            successToast(res.data.data);
            setTimeout(() => {
                router.visit("/OtpForm");
            },1000);
        }else{
            errorToast(res.data.data);
        }
    }catch(error){
        // Handle any API errors and display a meaningful message
        errorToast(error.response?.data?.data || "An error occurred. Please try again.");
    }finally{
        loading.value = false;
    }
}


// Back To Previous Page
const Back = () => {
    window.history.back();
};
// Back To Home Page
const Home = () => {
    router.visit('/');
}
</script>

<template>
    <div
      class="d-flex align-items-center justify-content-center"
      style="min-height: 100vh; background: linear-gradient(to right, #00c6ff, #0072ff);"
    >
      <div class="w-100" style="max-width: 400px;">
        <!-- Back Button -->
        <button @click.prevent="Back" :disabled="loading" class="btn btn-outline-light mb-3">
          <i class="bi bi-arrow-left"></i> Back
        </button>
        <!-- Back To Home Button -->
        <button @click.prevent="Home" :disabled="loading" class="btn mx-3 btn-outline-light mb-3">
          <i class="bi bi-arrow-left"></i> Home
        </button>

        <!-- Login Card -->
        <div class="card p-4">
          <h3 class="text-center mb-4">Login</h3>
          <form @submit.prevent="sendOTP">
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-envelope-fill"></i>
                </span>
                <input
                  v-model="email"
                  type="email"
                  class="form-control"
                  id="email"
                  placeholder="Enter your email"
                  required
                 :readonly="loading"
                />
              </div>
            </div>
            <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                <span v-if="loading" class="spinner-border spinner-border-sm"></span>
                <span v-else> Send OTP</span>
            </button>
          </form>
        </div>
      </div>
    </div>
    <!-- Features -->
    <features-comp />
    <!-- Contact -->
    <contact-comp />

    <!-- Footer -->
    <footer-comp />
  </template>

  <style scoped>
  /* Additional styling if needed */
  </style>
