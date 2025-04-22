<script setup>
import FeaturesComp from "../../Components/FeaturesComp.vue";
import ContactComp from "../../Components/ContactComp.vue";
import FooterComp from "../../Components/FooterComp.vue";
import { successToast, errorToast } from '@/utils/toast'
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

const otp = ref("");
const loading = ref(false); // Controls the loading state

// Verify OTP Functionality

const verifyOTP = async () => {
    loading.value = true; // Set loading state to prevent multiple clicks
    try {
        let email = localStorage.getItem("email"); // Get email from localStorage
        if (!email) {
            errorToast("Email not found");
            loading.value = false;
            return;
        } else if (!otp.value.trim()) {
            errorToast("Please enter your 6 digit verification code");
            loading.value = false;
            return;
        } else if (otp.value.length !== 6) {
            errorToast("Verification code must be 6 digits");
            loading.value = false;
            return;
        }

        let res = await axios.post("api/auth/verify-otp", {
            email: email,
            otp: otp.value,
        },{
            withCredentials: true
        });
        if (res.data.status === true) {
            localStorage.removeItem("email");
            successToast(res.data.data);
            setTimeout(() => {
                router.visit("/dashboard");
            }, 1000);
        } else {
            errorToast(res.data.data);
        }
    } catch (error) {
        // Handle any API errors and display a meaningful message
        errorToast(
            error.response?.data?.data || "An error occurred. Please try again."
        );
    } finally {
        loading.value = false;
    }
};

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
        style="
            min-height: 100vh;
            background: linear-gradient(to right, #00c6ff, #0072ff);
        "
    >
        <div class="w-100" style="max-width: 400px">
            <!-- Back Button -->
            <button
                @click.prevent="Back"
                :disabled="loading"
                class="btn btn-outline-light mb-3"
            >
                <i class="bi bi-arrow-left"></i> Back
            </button>
            <!-- Back To Home Button -->
            <button
                @click.prevent="Home"
                :disabled="loading"
                class="btn btn-outline-light mx-3 mb-3"
            >
                <i class="bi bi-arrow-left"></i> Home
            </button>

            <!-- Login Card -->
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
                        <span
                            v-if="loading"
                            class="spinner-border spinner-border-sm"
                        ></span>
                        <span v-else> Verify OTP</span>
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
