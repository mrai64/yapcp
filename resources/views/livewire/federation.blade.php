<div class="">
    <form wire:submit.prevent="changeName">
        @csrf 
        
        <div class="mt-2"> <!-- TODO __() -->

            <input 
                wire:model="name" 
                type="text" 
                class="p-4 border rounded-md bg-gray-700 text-blue w-full"
                placeholder="Name of federation"
            />
            
            <button 
                type="submit"
                class="mt-2 p-4 h-16 border rounded-md w-full bg-blue text-white"
                >
                Update
            </button>
        
        </div>
    </form>
</div>
