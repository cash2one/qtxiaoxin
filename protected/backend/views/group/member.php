
<?php if($ty=='0'): ?><!-- 选择学生界面 -->
    <div class="selectBox">
        <select id="teacher_class" vlaue="">
            <option value="">选择班级</option>
            <?php foreach($classes as $class): ?>
                <option value="<?php echo $class['cid']; ?>"><?php echo $class['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="memberBox" style="height: 260px;">
        <ul id="popMember" class=""> 
            <!--<li><a rel="chekedItime" class="" uit="0" data-usid="1" href="javascript:void(0);"><em class="userIco"></em><span>班级班级</span></a></li>-->
            <!--<li><a rel="chekedItime" class="" uit="0" data-usid="2" href="javascript:void(0);"><em class="userIco"></em><span>班级班级</span></a></li>--> 
        </ul>
    </div> 


<?php else: ?><!-- 选择老师界面 -->


    <div class="selectBox">
        <select id="teacher_class" vlaue="">
            <option value="">选择部门</option>
            <option value="allTeacher">全体老师</option>
            <?php foreach($departs as $depart): ?>
                <option value="<?php echo $depart['did']; ?>"><?php echo $depart['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="memberBox" style="height: 260px;"> 
        <ul id="popMember" class=""> 
        </ul>
    </div>  

<?php endif; ?>