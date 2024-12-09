@extends('entrepreneur.layout')

@section('title', 'Chat - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('content')
<div class="chat-container">
    <div class="chat-wrapper">
        <div class="contacts-sidebar">
            <div class="contacts-header">
                <h3>Conversations</h3>
                <div class="search-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search messages..." class="contact-search">
                </div>
            </div>
            <div class="contacts-list" id="contacts-list">
                <!-- Contacts will be populated dynamically -->
            </div>
        </div>
        
        <div class="chat-main">
            <div class="chat-header">
                <div class="chat-contact-info">
                    <img src="{{ asset('assets/default-avatar.png') }}" alt="Contact" class="avatar" id="chat-avatar">
                    <div class="contact-details">
                        <h4 id="chat-name">Select a conversation</h4>
                        <span class="status" id="chat-status">Start messaging</span>
                    </div>
                </div>
            </div>
            
            <div class="messages-container" id="messages">
                <!-- Messages will be populated dynamically -->
            </div>
            
            <div class="chat-input-area">
                <form id="message-form" class="message-form">
                    @csrf
                    <input type="text" placeholder="Type your message..." id="message-input" autocomplete="off">
                    <button type="submit">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Chat functionality will be added here
</script>
@endsection