<section class="text-center"> <!-- First section Mentalit-E definition & pic-->

<button class="open-button" id="top-button" onclick="openForm()"><i class="fa fa-question"></i></button>

<div class="form-popup shadow" id="myForm">
    <form class="form-container">
        <i class="fa fa-close pull-right" onclick="closeForm()"></i>
        <br>
        <h3>Select your concern</h3>
        <br>
        <div class="form-design" onclick="FAQopenForm()">Frequently Asked Questions</div>
        <br>
        <div class="form-design" onclick="ChatopenForm()">Chat with bot</div>
        <br>
        <div class="form-design" onclick="TicketopenForm()">File ticket</div>
        <br>			

        <br>
    </form>
</div>

<div class="form-popup shadow" id="FAQForm">
    <form class="form-container">
        <i class="fa fa-close pull-right" onclick="FAQcloseForm()"></i>
        <br>
        <h3>Frequently Asked Questions</h3>
        <br>
        <p>Q: Lorem Ipsum</p>
        <p>A: Lorem Ipsum</p>
        <hr>
        <p>Q: Lorem Ipsum</p>
        <p>A: Lorem Ipsum</p>
        <hr>
        <p>Q: Lorem Ipsum</p>
        <p>A: Lorem Ipsum</p>
        
        
    </form>
</div>

<div class="form-popup shadow" id="ChatForm">
    <form class="form-container">
        <i class="fa fa-close pull-right" onclick="ChatcloseForm()"></i>
        <br>
        <h4 class="text-center mt-3">Chat now!</h4>
        <br><hr class="divider"><br>
        <div class="d-flex justify-content-start text-left">
            <div class="p-2 ms-3 bd-highlight">
                <img src="img/user.png" class="mt-2" width=50>
            </div>
            <div class="p-2 me-5 bd-highlight">			
                <h5>Name</h5>
                <p class="w-100">
                    Message			
                </p>
                <p><i>2020-05-19 (date sent) 10:20 (time sent)</i></p>
            </div>						
        </div>	

        <div class="d-flex justify-content-start text-right">
            <div class="p-2 me-auto bd-highlight">			
            </div>							
            <div class="p-2 bd-highlight">			
                <h5>Name</h5>
                <p class="w-100">
                    Message			
                </p>
                <p><i>2020-05-19 (date sent) 10:20 (time sent)</i></p>
            </div>
            <div class="p-2 ms-3 bd-highlight">
                <img src="img/user.png" class="mt-2" width=50>
            </div>								
        </div>								
        <br>
        <div class="d-flex bd-highlight">
            <div class="p-2 w-100 bd-highlight">
                <textarea class="form-control">Send a message</textarea>
            </div>
            <div class="p-2">
                <img src="img/attachment.png" class="mt-2" width=30>
            </div>								
            <div class="p-2 flex-shrink-1 bd-highlight">
                <button type="submit" class="btn btn-outline-square">Send</button>
            </div>
        </div>
    </form>
</div>

<div class="form-popup shadow" id="TicketForm">
    <form class="form-container">
        <i class="fa fa-close pull-right" onclick="TicketcloseForm()"></i>
        <br>
        <h3>Send us a message</h3>
        <br>
        <input type="text" class="form-control" placeholder="Name" name="email" required>
        <br>
        <input type="text" class="form-control" placeholder="Email" name="email" required>		
        <br>
        <textarea class="form-control">Description</textarea>
        <br>
        <button type="submit" class="btn btn-outline btn-submit">Submit</button>
        <br>
    </form>
</div>	