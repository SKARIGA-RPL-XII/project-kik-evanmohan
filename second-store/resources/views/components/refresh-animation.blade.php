<div class="refresh-spinner"></div>

<style>
.refresh-spinner {
    width: 28px;
    height: 28px;
    border: 3px solid #dcdcdc;
    border-top-color: #4a90e2;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    display: inline-block;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}
</style>
