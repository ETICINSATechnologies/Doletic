// ----------------------- COMMENT INTERFACE SERVICES CLASS ----------------------------------

var CommentServicesInterface = new function() {

  this.meta = {
    // --- (object)
    OBJECT: 'comment',
    // --- (actions)
    ACTION: {
      GET_COMMENT_BY_ID:'byid',
      GET_ALL_COMMENTS:'all',
      INSERT: 'insert',
      UPDATE: 'update',
      DELETE: 'delete',
    }
  };

  this.getAll = function(successHandler) {
   return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_ALL_COMMENTS, 
            {}, 
            successHandler); 
  }

  this.getById = function(id, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_COMMENT_BY_ID, 
            { id: id }, 
            successHandler); 
  }

  this.insert = function(userId, data, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.INSERT, 
            {
              userId: userId,
              data: data
            },
            successHandler); 
  }

  this.update = function(id, data, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.UPDATE, 
            {
              id: id,
              data: data
            }, 
            successHandler); 
  }

  this.delete = function(id, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.DELETE, 
            { id: id }, 
            successHandler); 
  }

}

// ----------------------- SETTINGS INTERFACE SERVICES CLASS ----------------------------------

var SettingServicesInterface = new function() {

  this.meta = {
    // --- (object)
    OBJECT: 'setting',
    // --- (actions)
    ACTION: {
      GET_SETTING_BY_ID:'byid',
      GET_SETTING_BY_KEY:'bykey',
      GET_ALL_SETTINGS:'all',
      INSERT: 'insert',
      UPDATE: 'update',
      DELETE: 'delete'
    }
  };

  this.getAll = function(successHandler) {
   return DoleticServicesInterface.callService(this.meta.OBJECT,this.meta.ACTION.GET_ALL_SETTINGS,{},successHandler); 
  }

  this.getById = function(id, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_SETTING_BY_ID, 
            { id: id }, 
            successHandler); 
  }

  this.getByKey = function(key, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_SETTING_BY_KEY, 
            { key: key }, 
            successHandler); 
  }

  this.insert = function(key, value, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, 
            this.meta.ACTION.INSERT, 
            {
              key: key,
              value: value
            }, 
            successHandler); 
  }

  this.update = function(key, value, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, 
            this.meta.ACTION.UPDATE, 
            {
              key: key,
              value: value
            }, 
            successHandler); 
  }

  this.delete = function(key, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, 
            this.meta.ACTION.DELETE, 
            { key: key }, 
            successHandler); 
  }  

}

// ----------------------- USER DATA INTERFACE SERVICES CLASS ----------------------------------

var UserDataServicesInterface = new function() {

  this.meta = {
    // --- (object)
    OBJECT: 'udata',
    // --- (actions)
    ACTION: {
      GET_USER_DATA_BY_ID:"byidud",
      GET_USER_LAST_POS:"lastpos",
      GET_ALL_USER_DATA:"allud",
      GET_ALL_GENDERS:"allg",
      GET_ALL_COUNTRIES:"allc",
      GET_ALL_INSA_DEPTS:"alldept",
      GET_ALL_SCHOOL_YEARS:"allyear",
      GET_ALL_DIVISIONS:'alldiv',
      GET_ALL_POSITIONS:"allpos",
      GET_ALL_AGS:'allag',
      INSERT_AG:'insag',
      DELETE_AG:'delag',
      INSERT:"insert",
      UPDATE:"update",
      UPDATE_POSTION:"updatepos",
      UPDATE_AVATAR:"updateava",
      DELETE:"delete",
      DISABLE:"disable",
      ENABLE:"enable",
      STATS:"stats"
    }
  };

  this.getAll = function(successHandler) {
   return DoleticServicesInterface.callService(this.meta.OBJECT,this.meta.ACTION.GET_ALL_USER_DATA,{},successHandler); 
  }

  this.getAllGenders = function(successHandler) {
   return DoleticServicesInterface.callService(this.meta.OBJECT,this.meta.ACTION.GET_ALL_GENDERS,{},successHandler);
  }

  this.getAllCountries = function(successHandler) {
   return DoleticServicesInterface.callService(this.meta.OBJECT,this.meta.ACTION.GET_ALL_COUNTRIES,{},successHandler); 
  }

  this.getAllINSADepts = function(successHandler) {
   return DoleticServicesInterface.callService(this.meta.OBJECT,this.meta.ACTION.GET_ALL_INSA_DEPTS,{},successHandler); 
  } 

  this.getAllSchoolYears = function(successHandler) {
   return DoleticServicesInterface.callService(this.meta.OBJECT,this.meta.ACTION.GET_ALL_SCHOOL_YEARS,{},successHandler); 
  } 

  this.getAllDivisions = function(successHandler) {
   return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_DIVISIONS, {}, successHandler); 
  }

  this.getAllPositions = function(successHandler) {
   return DoleticServicesInterface.callService(this.meta.OBJECT,this.meta.ACTION.GET_ALL_POSITIONS,{},successHandler); 
  }  

  this.getById = function(id, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_USER_DATA_BY_ID, 
            { id: id }, 
            successHandler); 
  }
   this.insertAg = function(ag, presence, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.INSERT_AG, 
            { 
                ag:ag,
                presence:presence
            }, 
            successHandler); 
  }
  this.deleteAg = function(ag, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.DELETE_AG, 
            { ag:ag }, 
            successHandler); 
  } 
  this.getAllAgs = function(successHandler) {
    return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_AGS, {}, successHandler); 
  }

  this.getUserLastPos = function(userId, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_USER_LAST_POS, 
            { userId: userId }, 
            successHandler);
  }

  this.insert = function(userId, gender, firstname, lastname, birthdate, tel, email, address, city, postalCode, country, schoolYear, insaDept, position, ag, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, 
            this.meta.ACTION.INSERT, 
            {
              userId:userId,
              gender:gender,
              firstname:firstname,
              lastname:lastname,
              birthdate:birthdate,
              tel:tel,
              email:email,
              address:address,
              city:city,
              postalCode:postalCode,
              country:country,
              schoolYear:schoolYear,
              insaDept:insaDept,
              position:position,
              ag:ag
            }, 
            successHandler); 
  }

  this.update = function(id, userId, gender, firstname, lastname, birthdate, tel, email, address, city, postalCode, country, schoolYear, insaDept, position, ag, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, 
            this.meta.ACTION.UPDATE, 
            {
              id: id,
              userId:userId,
              gender:gender,
              firstname:firstname,
              lastname:lastname,
              birthdate:birthdate,
              tel:tel,
              email:email,
              address:address,
              city:city,
              postalCode:postalCode,
              country:country,
              schoolYear:schoolYear,
              insaDept:insaDept,
              position:position,
              ag:ag
            }, 
            successHandler); 
  }

  this.updateUserPosition = function(userId, position, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.UPDATE_POSTION, 
            { 
              userId: userId,
              position: position
            }, 
            successHandler);
  }
  this.updateUserAvatar = function(avatarId, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.UPDATE_AVATAR, 
            { 
              avatarId: avatarId
            }, 
            successHandler);
  }

  this.delete = function(id, userId, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.DELETE, 
            { 
              id: id,
              userId: userId
            }, 
            successHandler); 
  }

  this.disable = function(id, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.DISABLE, 
            { 
              id: id
            }, 
            successHandler); 
  }

  this.enable = function(id, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.ENABLE, 
            { 
              id: id
            }, 
            successHandler); 
  }

  this.getGlobalStats = function(successHandler) {
    return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.STATS, {}, successHandler); 
  }

}

// ----------------------- USER INTERFACE SERVICES CLASS ----------------------------------

var UserServicesInterface = new function() {

  this.meta = {
    // --- (object)
    OBJECT: 'user',
    // --- (actions)
    ACTION: {
      GET_USER_BY_ID:'byid',
      GET_ALL_USERS: 'all',
      GENERATE_CREDENTIALS:'gencred',
      INSERT: 'insert',
      UPDATE: 'update',
      DELETE: 'delete',
      DISABLE: 'disable',
      RESTORE: 'restore'
    }
  };

  this.getAll = function(successHandler) {
   return DoleticServicesInterface.callService(
            this.meta.OBJECT, 
            this.meta.ACTION.GET_ALL_USERS, 
            {}, 
            successHandler); 
  }

  this.getById = function(id, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, 
            this.meta.ACTION.GET_USER_BY_ID, 
            {
              id: id
            }, 
            successHandler); 
  }

  this.generateCredentials = function(firstname, lastname, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, 
            this.meta.ACTION.GENERATE_CREDENTIALS, 
            {
              firstname: firstname,
              lastname: lastname
            }, 
            successHandler); 
  }

  this.insert = function(username, password, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, 
            this.meta.ACTION.INSERT, 
            {
              username: username,
              hash: phpjsLight.sha1(password)
            }, 
            successHandler); 
  }

  this.update = function(id, password, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, 
            this.meta.ACTION.UPDATE, 
            {
              id: id,
              hash: phpjsLight.sha1(password)
            }, 
            successHandler); 
  }

  this.delete = function(id, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, 
            this.meta.ACTION.DELETE, 
            {
              id: id
            }, 
            successHandler); 
  }

  this.disable = function(id, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, 
            this.meta.ACTION.DISABLE, 
            {
              id: id
            }, 
            successHandler); 
  }

  this.restore = function(id, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, 
            this.meta.ACTION.RESTORE, 
            {
              id: id
            }, 
            successHandler); 
  }

}

// ----------------------- UPLOAD INTERFACE SERVICES CLASS ----------------------------------

  var UploadServicesInterface = new function() {

  this.meta = {
    // --- (object)
    OBJECT: 'upload',
    // --- (actions)
    ACTION: {
      GET_UPLOAD_BY_ID:'byid'
    }
  };

  this.getById = function(id, successHandler) {
    return DoleticServicesInterface.callService(
            this.meta.OBJECT, 
            this.meta.ACTION.GET_UPLOAD_BY_ID, 
            {
              id: id
            }, 
            successHandler); 
  }
}