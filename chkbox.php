<fieldset class="checkbox">
                <legend>Check the boxes that apply to this course:</legend>

                <p>
                    <label class="check-field">
                        <input <?php if ($fldPaperHeavy == "Paper Heavy") print " checked "; ?>
                            id="chkPaperHeavy"
                            name="chkPaperHeavy"
                            tabindex="420"
                            type="checkbox"
                            value="Paper Heavy">Paper Heavy</label>
                </p>

                <p>
                    <label class="check-field">
                        <input <?php if ($fldReadingHeavy == "Reading Heavy") print " unchecked "; ?>
                            id="chkReadingHeavy"
                            name="chkReadingHeavy"
                            tabindex="420"
                            type="checkbox"
                            value="Reading Heavy">Reading Heavy</label>
                </p>

                <p>
                    <label class="check-field">
                        <input <?php if ($fldTestHeavy == "Test Heavy") print " unchecked "; ?>
                            id="chkTestHeavy"
                            name="chkTestHeavy"
                            tabindex="420"
                            type="checkbox"
                            value="Test Heavy">Test Heavy</label>
                </p>

                <p>
                    <label class="check-field">
                        <input <?php if ($fldPopQuizzes == "Pop Quizzes") print " unchecked "; ?>
                            id="chkPopQuizzes"
                            name="chkPopQuizzes"
                            tabindex="420"
                            type="checkbox"
                            value="Pop Quizzes">Pop Quizzes</label>
                </p>

                <p>
                    <label class="check-field">
                        <input <?php if ($fldGroupProjects == "Group Projects") print " unchecked "; ?>
                            id="chkGroupProjects"
                            name="chkGroupProjects"
                            tabindex="420"
                            type="checkbox"
                            value="Group Projects">Group Projects</label>
                </p>

                <p>
                    <label class="check-field">
                        <input <?php if ($fldParticipationMatters == "Participation Matters") print " unchecked "; ?>
                            id="chkParticipationMatters"
                            name="chkParticipationMatters"
                            tabindex="420"
                            type="checkbox"
                            value="Participation Matters">Participation Matters</label>
                </p>


                <p>
                    <label class="check-field">
                        <input <?php if ($fldLotsOfHomework == "Lots of Homework") print " unchecked "; ?>
                            id="chkLotsOfHomework"
                            name="chkLotsOfHomework"
                            tabindex="420"
                            type="checkbox"
                            value="Lots of Homework">Lots of Homework</label>
                </p>

                <p>
                    <label class="check-field">
                        <input <?php if ($fldMandatoryAttendance == "Mandatory Attendance") print " unchecked "; ?>
                            id="chkMandatoryAttendance"
                            name="chkMandatoryAttendance"
                            tabindex="420"
                            type="checkbox"
                            value="Mandatory Attendance">Mandatory Attendance</label>
                </p>

                <p>
                    <label class="check-field">
                        <input <?php if ($fldTextbookUse == "Textbook Use") print " unchecked "; ?>
                            id="chkTextbookUse"
                            name="chkTextbookUse"
                            tabindex="420"
                            type="checkbox"
                            value="Textbook Use">Textbook Use</label>
                </p>



            </fieldset>



          $query .= 'fldPaperHeavy = ?, ';
        $query .= 'fldReadingHeavy = ?, ';
        $query .= 'fldTestHeavy = ?, ';
        $query .= 'fldPopQuizzes = ?, ';
        $query .= 'fldGroupProjects = ?, ';
        $query .= 'fldParticipationMatters = ?, ';
        $query .= 'fldLotsOfHomework = ?, ';
        $query .= 'fldMandatoryAttendance = ?, ';
        $query .= 'fldTextbookUse = ?, ';
        
        
        
        $dataRecord[] = $fldPaperHeavy;
        $dataRecord[] = $fldReadingHeavy;
        $dataRecord[] = $fldTestHeavy;
        $dataRecord[] = $fldPopQuizzes;
        
        $dataRecord[] = $fldParticipationMatters;
        $dataRecord[] = $fldLotsOfHomework;
        $dataRecord[] = $fldMandatoryAttendance;
        $dataRecord[] = $fldTextbookUse;