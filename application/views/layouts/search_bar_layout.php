
                    <!-- Topbar Search -->
                    <div style="width:100%;" 
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-12 my-2 my-md-0  navbar-search">
                        
                        <div class="input-group">
                            <input  type="text" id="free_keyword_author" name="free_keyword_author" class="form-control bg-light border-0 small search_book_field " placeholder="Cerca per..."
                                aria-label="Filtro" style="display:none;" >
                            <input type="text" id="free_keyword_text" name="free_keyword_text" class="form-control bg-light border-0 small search_book_field " placeholder="Cerca per..."
                                aria-label="Filtro" style="display:none;">
                            <input type="text" id="free_keyword_annotation" name="free_keyword_annotation" class="form-control bg-light border-0 small search_book_field " placeholder="Cerca per..."
                                aria-label="Filtro" style="display:none;" >
                       <div class="form-check">
                       <select id="year_from" name="year_from" class="form-control border-0 small search_book_field "
                       style="display:none;">
                       <option value="-1">Anno da </option>
                       <?php 
                                 foreach ($resultDateYear as $dateFrom) { 
                                 echo    '<option value="'.$dateFrom["year"].'">'.$dateFrom["year"].'</option>';
                                }?>
                      </select>
                      <select id="year_to" name="year_to" class="form-control border-0 small search_book_field "
                      style="display:none;">
                      <option value="-1">Anno a </option>
                       <?php 
                                 foreach ($resultDateYear as $dateTo) { 
                                 echo    '<option value="'.$dateTo["year"].'">'.$dateTo["year"].'</option>';
                                }?>
                      </select>
                      <select id="century_from" name="century_from" class="form-control border-0 small search_book_field "
                      style="display:none;">
                      <option value="-1">Secolo da </option>
                       <?php 
                                 foreach ($resultDateCentury as $centuryFrom) { 
                                 echo    '<option value="'.$centuryFrom["century"].'">'.$centuryFrom["century"].'</option>';
                                }?>
                      </select>
                      </select>
                      <select id="century_to" name="century_to" class="form-control border-0 small search_book_field "
                      style="display:none;">
                      <option value="-1">Secolo a </option>
                       <?php 
                                 foreach ($resultDateCentury as $centuryTo) { 
                                 echo    '<option value="'.$centuryTo["century"].'">'.$centuryTo["century"].'</option>';
                                }?>
                      </select>
                      </select>

                       <select onchange="showSearchField(this, 'search_book_field')" id="searchfor" name="searchfor" class="form-control border-0 small">
                                <option value="-1">Seleziona filtro</option>
                                <option label_value="traduttore" value="free_keyword_author">Traduttore</option>
                                <option label_value="anno" value="year_from,year_to">Anno</option>
                                <option label_value="secolo"  value="century_from,century_to">Secolo</option>
                                <option label_value="nel testo" value="free_keyword_text">Nei testi</option>
                                <option label_value="nelle annotazioni" value="free_keyword_annotation">Nelle annotazioni</option>
                                <option label_value="nei tag" value="free_keyword_tag">Tag</option>
                                
                            </select>
                             <!--   <input name="authorcheck" class="form-check-input" type="checkbox" id="authorcheck" >
                                <label class="form-check-label" for="authorcheck">
                                    Autore 
                                </label>
                                <input name="contentcheck" class="form-check-input" type="checkbox"  id="contentcheck" >
                                <label class="form-check-label" for="contentcheck">
                                    Parola 
                                </label>
                                <input name="yearcheck" class="form-check-input" type="checkbox" id="yearcheck" >
                                <label class="form-check-label" for="yearcheck">
                                    Anno
                                </label>
                                <input name="centurycheck" class="form-check-input"  type="checkbox" id="centurycheck" >
                                <label class="form-check-label" for="centurycheck">
                                    Secolo
                                </label>
                                 -->
                            </div>
                           
                            <select id="language" name="language" class="form-control border-0 small">
                                <option value="-1">Seleziona lingua (nessuna selezione per tutte)</option>
                                <?php 
                                
                                
                                foreach ($resultLanguages as $lang) { 
                                 echo    '<option label_value="'.$lang["language"].' ('.$lang["code"].')" value="'.$lang["id"].'">'.$lang["language"].' ('.$lang["code"].')</option>';
                                }?>
                               
                            </select>
                            
                             

                            <div class="input-group-append">
                            <div  class="btn btn-primary" onClick="addToFilter()" type="button">
                                    <i class="fas fa-plus fa-sm"></i>
                            </div>
                                <div  class="btn btn-primary" onClick="searchBook()" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                            </div>
                            </div>
                        </div>
                        
                    </div>