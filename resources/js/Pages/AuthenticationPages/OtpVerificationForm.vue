<script setup>
import { ref, computed } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import axios from "axios";
import { successToast, errorToast } from "@/utils/toast";

import FeaturesComp from "../../Components/FeaturesComp.vue";
import ContactComp from "../../Components/ContactComp.vue";
import FooterComp from "../../Components/FooterComp.vue";

// State
const otp = ref("");
const loading = ref(false);
const userRole = computed(() => usePage().props.role);

// Navigation Handlers
const Back = () => window.history.back();
const Home = () => router.visit("/");

// OTP Validation
const validateOTP = () => {
  if (!otp.value.trim()) {
    errorToast("Please enter your 6 digit verification code");
    return false;
  }

  if (otp.value.length !== 6) {
    errorToast("Verification code must be 6 digits");
    return false;
  }

  return true;
};

// Verify OTP Function
const verifyOTP = async () => {
  loading.value = true;

  try {
    const email = localStorage.getItem("email");

    if (!email) {
      errorToast("Email not found");
      return;
    }

    if (!validateOTP()) return;

    const { data } = await axios.post(
      "api/auth/verify-otp",
      { email, otp: otp.value },
      { withCredentials: true }
    );

    if (data.status === true) {
      localStorage.removeItem("email");
      successToast(data.data);

      setTimeout(() => {
                if(userRole.value && userRole.value !== 'admin'){
                    router.visit("/contact");
                }else{
                    router.visit("/dashboard");
                }

            }, 1000);
    } else {
      errorToast(data.data || "Invalid OTP. Please try again.");
    }
  } catch (error) {
    if (error.response?.status === 408) {
      errorToast("OTP expired. Redirecting to login page...");
      setTimeout(() => router.visit("/LoginForm"), 1500);
    } else {
      errorToast(error.response?.data?.data || "An error occurred. Please try again.");
    }
  } finally {
    loading.value = false;
  }
};
</script>


<template>
    <div
        class="d-flex align-items-center justify-content-center"
        style="min-height: 100vh; background: linear-gradient(to right, #00c6ff, #0072ff);"
    >
        <div class="w-100" style="max-width: 400px">
            <!-- Back & Home Buttons -->
            <div class="mb-3 d-flex">
                <button
                    @click.prevent="Back"
                    :disabled="loading"
                    class="btn btn-outline-light me-2"
                >
                    <i class="bi bi-arrow-left"></i> Back
                </button>
                <button
                    @click.prevent="Home"
                    :disabled="loading"
                    class="btn btn-outline-light"
                >
                    <i class="bi bi-house-door-fill"></i> Home
                </button>
            </div>

            <!-- OTP Card -->
            <div class="card p-4">
                <h3 class="text-center mb-4">Verify OTP</h3>
                <form @submit.prevent="verifyOTP">
                    <div class="mb-3">
                        <label for="otp" class="form-label">OTP</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-shield-lock-fill"></i>
                            </span>
                            <input
                                v-model="otp"
                                type="text"
                                class="form-control"
                                id="otp"
                                placeholder="Enter your 6 digit verification code"
                                required
                                :readonly="loading"
                            />
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                        :disabled="loading"
                    >
                        <span v-if="loading" class="spinner-border spinner-border-sm"></span>
                        <span v-else>
                            <i class="bi bi-check-circle-fill me-1"></i> Verify OTP
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Additional Sections -->
    <features-comp />
    <contact-comp />
    <footer-comp />
</template>

<style scoped>
/* Additional styling if needed */
</style>
