// Share Modal Functionality
document.addEventListener("DOMContentLoaded", () => {
    // Modal elements
    const shareButton = document.querySelector("header .btn-hover-effect")
    const shareModal = document.getElementById("shareModal")
    const closeModal = document.getElementById("closeModal")
    const cancelShare = document.getElementById("cancelShare")
    const shareForm = document.getElementById("shareForm")
    const privacySelect = document.getElementById("codePrivacy")
    const passwordContainer = document.getElementById("passwordContainer")
  
    // Track form submission state
    let isSubmitting = false
  
    // Track the selected language
    let currentLanguage = "javascript"
    const languageSelect = document.getElementById("language")
    if (languageSelect) {
      currentLanguage = languageSelect.value
      languageSelect.addEventListener("change", function () {
        currentLanguage = this.value
      })
    }
  
    // Show the modal when share button is clicked
    if (shareButton) {
      shareButton.addEventListener("click", (e) => {
        e.preventDefault()
        // Reset form when opening modal
        if (shareForm) shareForm.reset()
        shareModal.classList.remove("hidden")
        document.body.classList.add("overflow-hidden")
      })
    }
  
    // Close modal functions
    const closeShareModal = () => {
      if (isSubmitting) return // Don't close if submitting
      shareModal.classList.add("hidden")
      document.body.classList.remove("overflow-hidden")
      // Reset form when closing modal
      if (shareForm) shareForm.reset()
    }
  
    if (closeModal) closeModal.addEventListener("click", closeShareModal)
    if (cancelShare) cancelShare.addEventListener("click", closeShareModal)
  
    // Close modal when clicking outside
    if (shareModal) {
      shareModal.addEventListener("click", (e) => {
        if (e.target === shareModal || e.target.classList.contains("backdrop-blur-sm")) {
          closeShareModal()
        }
      })
    }
  
    // Toggle password field based on privacy selection
    if (privacySelect) {
      privacySelect.addEventListener("change", function () {
        if (this.value === "private") {
          passwordContainer.classList.remove("hidden")
        } else {
          passwordContainer.classList.add("hidden")
        }
      })
    }
  
    // Submit the form
    if (shareForm) {
      // Remove any existing submit event listeners
      shareForm.replaceWith(shareForm.cloneNode(true))
  
      // Get the fresh reference after replacing
      const freshShareForm = document.getElementById("shareForm")
  
      freshShareForm.addEventListener("submit", async (e) => {
        e.preventDefault()
  
        // Prevent double submission
        if (isSubmitting) {
          console.log("Form is already submitting...")
          return
        }
  
        // Get form elements
        const titleInput = document.getElementById("codeTitle")
        const descriptionInput = document.getElementById("codeDescription")
  
        // Validate title
        if (!titleInput || !titleInput.value.trim()) {
          alert("Please enter a title for your code")
          return
        }
  
        // Set submitting state
        isSubmitting = true
  
        // Create FormData object
        const formData = new FormData()
  
        // Manually append form data to ensure correct values
        formData.append("title", titleInput.value.trim())
        formData.append("description", descriptionInput ? descriptionInput.value.trim() : "")
        formData.append("privacy", privacySelect ? privacySelect.value : "private")
  
        // Get the code from the global editor instance
        if (!window.editor) {
          alert("Editor not initialized properly. Please try again.")
          isSubmitting = false
          return
        }
  
        // Add editor content and language to form data
        formData.append("code", window.editor.getValue())
        formData.append("language", currentLanguage)
  
        // Add password if privacy is private
        if (privacySelect && privacySelect.value === "private") {
          const passwordInput = document.getElementById("codePassword")
          if (passwordInput && passwordInput.value) {
            formData.append("password", passwordInput.value)
          }
        }
  
        // Debug log form data
        for (const [key, value] of formData.entries()) {
          console.log(`${key}: ${value}`)
        }
  
        // Show loading state
        const submitBtn = document.getElementById("submitShare")
        const originalBtnText = submitBtn.innerHTML
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sharing...'
        submitBtn.disabled = true
  
        try {
          const response = await fetch("./server/save_code.php", {
            method: "POST",
            body: formData,
          })
  
          const data = await response.json()
  
          if (data.success) {
            const shareUrl = `${window.location.origin}/view.php?url=${data.url}`
  
            // Copy URL to clipboard
            await navigator.clipboard.writeText(shareUrl)
  
            alert("Code shared successfully! The link has been copied to your clipboard: " + shareUrl)
            closeShareModal()
          } else {
            alert("Error: " + (data.message || "Failed to share code"))
          }
        } catch (error) {
          console.error("Error:", error)
          alert("An error occurred while sharing your code.")
        } finally {
          // Reset states
          isSubmitting = false
          submitBtn.innerHTML = originalBtnText
          submitBtn.disabled = false
        }
      })
    }
  })
  
  