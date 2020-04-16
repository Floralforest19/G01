<h2>Skapa ny produkt</h2>
    
<form   action="#"       
        enctype="multipart/form-data"  
        method="post" 
        class="row">


<div class="col-md-12 form-group">
        <input  type="file" 
                name="image" 
                id="fileToUpload" 
                class="form-control">
    </div>
    
    <div class="col-md-12 form-group">
        <input  type="file" 
                name="image" 
                id="fileToUpload" 
                class="form-control">
    </div>
    
    <div class="col-md-12 form-group">
        <input  type="file" 
                name="image" 
                id="fileToUpload" 
                class="form-control">
    </div>
    
    <div class="col-md-12 form-group">
        <input  type="file" 
                name="image" 
                id="fileToUpload" 
                class="form-control">
    </div>

    <div class="col-md-12 form-group">
        <input  type="file" 
                name="image" 
                id="fileToUpload" 
                class="form-control">
    </div>

    <label for="categori">Välj kategori</label>

<select id="categori">
  <option value="hygien">Hygien</option>
  <option value="mat">Mat</option>
  <option value="rosor">Rosor</option>
</select>


    <div class="col-md-12 form-group">
        <input name="heading" type="text" required
        class="form-control" placeholder="Produktnamn">
    </div>   
      
    <div class="col-md-12 form-group">
        <textarea name="content" cols="30" rows="5" required
        class="form-control" placeholder="Beskrivning"></textarea>
    </div>

    <div class="col-md-12 form-group">
    <label for="quantity">Antal:</label>
    <input type="number" id="quantity" name="quantity" min="1" required>
    </div>   
        
    <div class="col-md-12 form-group">
    <label for="quantity">Pris:</label>
    <input type="number" id="quantity" name="quantity" min="1" required>
    </div>  
    
    <div class="col-md-12 form-group">
        <input  type="submit" 
                value="Lägg till"
                class="btn btn-success form-control">
    </div>
</form>