// ----------------------- DBService INTERFACE SERVICES CLASS ----------------------------------

var KernelDBServicesInterface = new function () {

    this.meta = {
        // --- (object)
        OBJECT: 'modkernel',
        // --- (actions)
        ACTION: {
            GET_ALL_UDATA_WITH_STATUS: 'alluwsta',
            GET_ALL_TEAMS_WITH_NAMES: 'alltwname'
        }
    };

    this.getAllUserDataWithStatus = function (successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_ALL_UDATA_WITH_STATUS,
            {},
            successHandler);
    };

    this.getAllTeamsWithNames = function (successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_ALL_TEAMS_WITH_NAMES,
            {},
            successHandler);
    }

};

// ----------------------- COMMENT INTERFACE SERVICES CLASS ----------------------------------

var CommentServicesInterface = new function () {

    this.meta = {
        // --- (object)
        OBJECT: 'comment',
        // --- (actions)
        ACTION: {
            GET_COMMENT_BY_ID: 'byid',
            GET_ALL_COMMENTS: 'all',
            INSERT: 'insert',
            UPDATE: 'update',
            DELETE: 'delete'
        }
    };

    this.getAll = function (successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_ALL_COMMENTS,
            {},
            successHandler);
    };

    this.getById = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_COMMENT_BY_ID,
            {id: id},
            successHandler);
    };

    this.insert = function (userId, data, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.INSERT,
            {
                userId: userId,
                data: data
            },
            successHandler);
    };

    this.update = function (id, data, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.UPDATE,
            {
                id: id,
                data: data
            },
            successHandler);
    };

    this.delete = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.DELETE,
            {id: id},
            successHandler);
    }

};

// ----------------------- SETTINGS INTERFACE SERVICES CLASS ----------------------------------

var SettingServicesInterface = new function () {

    this.meta = {
        // --- (object)
        OBJECT: 'setting',
        // --- (actions)
        ACTION: {
            GET_SETTING_BY_ID: 'byid',
            GET_SETTING_BY_KEY: 'bykey',
            GET_ALL_SETTINGS: 'all',
            INSERT: 'insert',
            UPDATE: 'update',
            DELETE: 'delete'
        }
    };

    this.getAll = function (successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_SETTINGS, {}, successHandler);
    };

    this.getById = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_SETTING_BY_ID,
            {id: id},
            successHandler);
    };

    this.getByKey = function (key, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_SETTING_BY_KEY,
            {key: key},
            successHandler);
    };

    this.insert = function (key, value, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT,
            this.meta.ACTION.INSERT,
            {
                key: key,
                value: value
            },
            successHandler);
    };

    this.update = function (key, value, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT,
            this.meta.ACTION.UPDATE,
            {
                key: key,
                value: value
            },
            successHandler);
    };

    this.delete = function (key, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT,
            this.meta.ACTION.DELETE,
            {key: key},
            successHandler);
    }

};

// ----------------------- USER DATA INTERFACE SERVICES CLASS ----------------------------------

var UserDataServicesInterface = new function () {

    this.meta = {
        // --- (object)
        OBJECT: 'udata',
        // --- (actions)
        ACTION: {
            GET_USER_DATA_BY_ID: "byidud",
            GET_USER_DATA_BY_USER_ID: "byuidud",
            GET_USER_LAST_POS: "lastpos",
            GET_ALL_USER_DATA: "allud",
            GET_ALL_BY_DIV: "allbydiv",
            GET_ALL_BY_POS: "allbypos",
            GET_ALL_BY_DPT: "allbydpt",
            GET_ALL_GENDERS: "allg",
            GET_ALL_COUNTRIES: "allc",
            GET_ALL_INSA_DEPTS: "alldept",
            GET_ALL_SCHOOL_YEARS: "allyear",
            GET_ALL_DIVISIONS: 'alldiv',
            GET_ALL_POSITIONS: "allpos",
            GET_ALL_AGS: 'allag',
            INSERT_AG: 'insag',
            DELETE_AG: 'delag',
            INSERT: "insert",
            UPDATE: "update",
            UPDATE_POSTION: "updatepos",
            UPDATE_AVATAR: "updateava",
            DELETE: "delete",
            DISABLE: "disable",
            ENABLE: "enable",
            TAG_OLD: "old",
            UNTAG_OLD: "unold"
        }
    };

    this.getAll = function (successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_USER_DATA, {}, successHandler);
    };

    this.getAllByDivision = function (division, successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_BY_DIV,
            {
                division: division
            },
            successHandler);
    };

    this.getAllByPosition = function (position, successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_BY_POS,
            {
                position: position
            },
            successHandler);
    };

    this.getAllByDept = function (insaDept, successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_BY_DPT,
            {
                insaDept: insaDept
            },
            successHandler);
    };

    this.getAllGenders = function (successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_GENDERS, {}, successHandler);
    };

    this.getAllCountries = function (successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_COUNTRIES, {}, successHandler);
    };

    this.getAllINSADepts = function (successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_INSA_DEPTS, {}, successHandler);
    };

    this.getAllSchoolYears = function (successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_SCHOOL_YEARS, {}, successHandler);
    };

    this.getAllDivisions = function (successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_DIVISIONS, {}, successHandler);
    };

    this.getAllPositions = function (successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_POSITIONS, {}, successHandler);
    };

    this.getById = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_USER_DATA_BY_ID,
            {id: id},
            successHandler);
    };

    this.getByUserId = function (user_id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_USER_DATA_BY_USER_ID,
            {userId: user_id},
            successHandler);
    };

    this.insertAg = function (ag, presence, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.INSERT_AG,
            {
                ag: ag,
                presence: presence
            },
            successHandler);
    };
    this.deleteAg = function (ag, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.DELETE_AG,
            {ag: ag},
            successHandler);
    };
    this.getAllAgs = function (successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_AGS, {}, successHandler);
    };

    this.getUserLastPos = function (userId, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_USER_LAST_POS,
            {userId: userId},
            successHandler);
    };

    this.insert = function (userId, gender, firstname, lastname, birthdate, tel, email, address, city, postalCode, country, schoolYear, insaDept, position, ag, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT,
            this.meta.ACTION.INSERT,
            {
                userId: userId,
                gender: gender,
                firstname: firstname,
                lastname: lastname,
                birthdate: birthdate,
                tel: tel,
                email: email,
                address: address,
                city: city,
                postalCode: postalCode,
                country: country,
                schoolYear: schoolYear,
                insaDept: insaDept,
                position: position,
                ag: ag
            },
            successHandler);
    };

    this.update = function (id, userId, gender, firstname, lastname, birthdate, tel, email, address, city, postalCode, country, schoolYear, insaDept, position, ag, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT,
            this.meta.ACTION.UPDATE,
            {
                id: id,
                userId: userId,
                gender: gender,
                firstname: firstname,
                lastname: lastname,
                birthdate: birthdate,
                tel: tel,
                email: email,
                address: address,
                city: city,
                postalCode: postalCode,
                country: country,
                schoolYear: schoolYear,
                insaDept: insaDept,
                position: position,
                ag: ag
            },
            successHandler);
    };

    this.updateUserPosition = function (userId, position, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.UPDATE_POSTION,
            {
                userId: userId,
                position: position
            },
            successHandler);
    };
    this.updateUserAvatar = function (avatarId, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.UPDATE_AVATAR,
            {
                avatarId: avatarId
            },
            successHandler);
    };

    this.delete = function (id, userId, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.DELETE,
            {
                id: id,
                userId: userId
            },
            successHandler);
    };

    this.disable = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.DISABLE,
            {
                id: id
            },
            successHandler);
    };

    this.enable = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.ENABLE,
            {
                id: id
            },
            successHandler);
    }

    this.tagOld = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.TAG_OLD,
            {
                id: id
            },
            successHandler);
    };

    this.untagOld = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.UNTAG_OLD,
            {
                id: id
            },
            successHandler);
    }

};

// ----------------------- USER INTERFACE SERVICES CLASS ----------------------------------

var UserServicesInterface = new function () {

    this.meta = {
        // --- (object)
        OBJECT: 'user',
        // --- (actions)
        ACTION: {
            GET_USER_BY_ID: 'byid',
            GET_ALL_USERS: 'all',
            GENERATE_CREDENTIALS: 'gencred',
            INSERT: 'insert',
            UPDATE: 'update',
            DELETE: 'delete',
            DISABLE: 'disable',
            RESTORE: 'restore'
        }
    };

    this.getAll = function (successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT,
            this.meta.ACTION.GET_ALL_USERS,
            {},
            successHandler);
    };

    this.getById = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT,
            this.meta.ACTION.GET_USER_BY_ID,
            {
                id: id
            },
            successHandler);
    };

    this.generateCredentials = function (firstname, lastname, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT,
            this.meta.ACTION.GENERATE_CREDENTIALS,
            {
                firstname: firstname,
                lastname: lastname
            },
            successHandler);
    };

    this.insert = function (username, password, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT,
            this.meta.ACTION.INSERT,
            {
                username: username,
                hash: phpjsLight.sha1(password)
            },
            successHandler);
    };

    this.update = function (id, password, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT,
            this.meta.ACTION.UPDATE,
            {
                id: id,
                hash: phpjsLight.sha1(password)
            },
            successHandler);
    };

    this.delete = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT,
            this.meta.ACTION.DELETE,
            {
                id: id
            },
            successHandler);
    };

    this.disable = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT,
            this.meta.ACTION.DISABLE,
            {
                id: id
            },
            successHandler);
    };

    this.restore = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT,
            this.meta.ACTION.RESTORE,
            {
                id: id
            },
            successHandler);
    }

};

// ----------------------- UPLOAD INTERFACE SERVICES CLASS ----------------------------------

var UploadServicesInterface = new function () {

    this.meta = {
        // --- (object)
        OBJECT: 'upload',
        // --- (actions)
        ACTION: {
            GET_UPLOAD_BY_ID: 'byid'
        }
    };

    this.getById = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT,
            this.meta.ACTION.GET_UPLOAD_BY_ID,
            {
                id: id
            },
            successHandler);
    }
};

// ----------------------- INDICATOR INTERFACE SERVICES CLASS ----------------------------------

var IndicatorServicesInterface = new function () {

    this.meta = {
        // --- (object)
        OBJECT: 'indicator',
        // --- (actions)
        ACTION: {
            GET_BY_ID: 'byid',
            GET_ALL: 'all',
            GET_ALL_BY_MODULE: 'allbymod',
            GET_ALL_VALUE: 'allval',
            GET_ALL_GRAPH: 'allgra',
            GET_ALL_TABLE: 'alltab',
            GET_ALL_VALUE_BY_MODULE: 'allvalbymod',
            GET_ALL_GRAPH_BY_MODULE: 'allgrabymod',
            GET_ALL_TABLE_BY_MODULE: 'alltabbymod',
            PROCESS_BY_ID: 'procbyid',
            PROCESS_ALL: 'procall',
            PROCESS_ALL_BY_MODULE: 'procallbymod',
            PROCESS_ALL_VALUE: 'procval',
            PROCESS_ALL_GRAPH: 'procgra',
            PROCESS_ALL_TABLE: 'proctab',
            PROCESS_ALL_VALUE_BY_MODULE: 'procvalbymod',
            PROCESS_ALL_GRAPH_BY_MODULE: 'procgrabymod',
            PROCESS_ALL_TABLE_BY_MODULE: 'proctabbymod',
            INSERT_VALUE: 'insval',
            INSERT_GRAPH: 'insgra',
            INSERT_TABLE: 'instab',
            UPDATE_VALUE: 'updval',
            UPDATE_GRAPH: 'updgra',
            UPDATE_TABLE: 'updtab',
            DISABLE: 'disable',
            ENABLE: 'enable',
            DELETE: 'delete'
        }
    };

    this.getAll = function (successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_ALL,
            {},
            successHandler);
    };

    this.processAll = function (successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.PROCESS_ALL,
            {},
            successHandler);
    };

    this.getAllByModule = function (module, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_ALL_BY_MODULE,
            {
                module: module
            },
            successHandler);
    };

    this.processAllByModule = function (module, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.PROCESS_ALL_BY_MODULE,
            {
                module: module
            },
            successHandler);
    };

    this.getById = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_BY_ID,
            {id: id},
            successHandler);
    };

    this.processById = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.PROCESS_BY_ID,
            {id: id},
            successHandler);
    };

    this.getAllValue = function (successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_ALL_VALUE,
            {},
            successHandler);
    };

    this.processAllValue = function (successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.PROCESS_ALL_VALUE,
            {},
            successHandler);
    };

    this.getAllGraph = function (successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_ALL_GRAPH,
            {},
            successHandler);
    };

    this.processAllGraph = function (successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.PROCESS_ALL_GRAPH,
            {},
            successHandler);
    };

    this.getAllTable = function (successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_ALL_TABLE,
            {},
            successHandler);
    };

    this.processAllTable = function (successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.PROCESS_ALL_TABLE,
            {},
            successHandler);
    };

    this.getAllValueByModule = function (module, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_ALL_VALUE_BY_MODULE,
            {
                module: module
            },
            successHandler);
    };

    this.processAllValueByModule = function (module, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.PROCESS_ALL_VALUE_BY_MODULE,
            {
                module: module
            },
            successHandler);
    };

    this.getAllGraphByModule = function (module, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_ALL_GRAPH_BY_MODULE,
            {
                module: module
            },
            successHandler);
    };

    this.processAllGraphByModule = function (module, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.PROCESS_ALL_GRAPH_BY_MODULE,
            {
                module: module
            },
            successHandler);
    };

    this.getAllTableByModule = function (module, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_ALL_TABLE_BY_MODULE,
            {
                module: module
            },
            successHandler);
    };

    this.processAllTableByModule = function (module, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.PROCESS_ALL_TABLE_BY_MODULE,
            {
                module: module
            },
            successHandler);
    };

    this.insertValue = function (procedure, module, description, params, expectedResult, unit, expectedGreater, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.INSERT_VALUE,
            {
                procedure: procedure,
                module: module,
                description: description,
                params: params,
                expectedResult: expectedResult,
                unit: unit,
                expectedGreater: expectedGreater
            },
            successHandler);
    };

    this.insertGraph = function (procedure, module, description, params, graphType, legend, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.INSERT_GRAPH,
            {
                procedure: procedure,
                module: module,
                description: description,
                params: params,
                graphType: graphType,
                legend: legend
            },
            successHandler);
    };

    this.insertTable = function (procedure, module, description, params, labelColumn, resultColumn, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.INSERT_TABLE,
            {
                procedure: procedure,
                module: module,
                description: description,
                params: params,
                labelColumn: labelColumn,
                resultColumn: resultColumn
            },
            successHandler);
    };

    this.updateValue = function (id, procedure, module, description, params, expectedResult, unit, expectedGreater, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.UPDATE_VALUE,
            {
                id: id,
                procedure: procedure,
                module: module,
                description: description,
                params: params,
                expectedResult: expectedResult,
                unit: unit,
                expectedGreater: expectedGreater
            },
            successHandler);
    };

    this.updateGraph = function (id, procedure, module, description, params, graphType, legend, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.UPDATE_GRAPH,
            {
                id: id,
                procedure: procedure,
                module: module,
                description: description,
                params: params,
                graphType: graphType,
                legend: legend
            },
            successHandler);
    };

    this.updateTable = function (id, procedure, module, description, params, labelColumn, resultColumn, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.UPDATE_TABLE,
            {
                id: id,
                procedure: procedure,
                module: module,
                description: description,
                params: params,
                labelColumn: labelColumn,
                resultColumn: resultColumn
            },
            successHandler);
    };

    this.disable = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.DISABLE,
            {id: id},
            successHandler);
    };

    this.enable = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.ENABLE,
            {id: id},
            successHandler);
    };

    this.delete = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.DELETE,
            {id: id},
            successHandler);
    }

};

// ----------------------- ADM_MEMBERSHIP INTERFACE SERVICES CLASS ----------------------------------

var AdmMembershipServicesInterface = new function () {

    this.meta = {
        // --- (object)
        OBJECT: 'adm_membership',
        // --- (actions)
        ACTION: {
            GET_ADM_MEMBERSHIP_BY_ID: 'byidam',
            GET_ALL_ADM_MEMBERSHIPS: 'allam',
            GET_USER_ADM_MEMBERSHIPS: 'alluam',
            GET_CURRENT_ADM_MEMBERSHIP: 'valadmm',
            INSERT: 'insert',
            UPDATE: 'update',
            DELETE: 'delete'
        }
    };

    this.getAll = function (successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_ADM_MEMBERSHIPS, {}, successHandler);
    };
    this.getUserAdmMemberships = function (userId, successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_USER_ADM_MEMBERSHIPS,
            {
                userId: userId
            },
            successHandler);
    };
    this.getCurrentAdmMembership = function (userId, successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_CURRENT_ADM_MEMBERSHIP,
            {
                userId: userId
            },
            successHandler);
    };
    this.getById = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_ADM_MEMBERSHIP_BY_ID,
            {id: id},
            successHandler);
    };
    this.insert = function (userId, startDate, endDate, fee, form, certif, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.INSERT,
            {
                userId: userId,
                startDate: startDate,
                endDate: endDate,
                fee: fee,
                form: form,
                certif: certif
            },
            successHandler);
    };
    this.update = function (id, userId, startDate, endDate, fee, form, certif, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.UPDATE,
            {
                id: id,
                userId: userId,
                startDate: startDate,
                endDate: endDate,
                fee: fee,
                form: form,
                certif: certif
            },
            successHandler);
    };
    this.delete = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.DELETE,
            {id: id},
            successHandler);
    }
};

// ----------------------- INT_MEMBERSHIP INTERFACE SERVICES CLASS ----------------------------------

var IntMembershipServicesInterface = new function () {

    this.meta = {
        // --- (object)
        OBJECT: 'int_membership',
        // --- (actions)
        ACTION: {
            GET_INT_MEMBERSHIP_BY_ID: 'byidim',
            GET_ALL_INT_MEMBERSHIPS: 'allim',
            GET_USER_INT_MEMBERSHIPS: 'alluim',
            INSERT: 'insert',
            UPDATE: 'update',
            DELETE: 'delete'
        }
    };

    this.getAll = function (successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_INT_MEMBERSHIPS, {}, successHandler);
    };
    this.getUserIntMemberships = function (userId, successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_USER_INT_MEMBERSHIPS,
            {
                userId: userId
            },
            successHandler);
    };
    this.getById = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_INT_MEMBERSHIP_BY_ID,
            {id: id},
            successHandler);
    };
    this.insert = function (userId, startDate, fee, form, certif, rib, identity, secuNumber, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.INSERT,
            {
                userId: userId,
                startDate: startDate,
                fee: fee,
                form: form,
                certif: certif,
                rib: rib,
                identity: identity,
                secuNumber: secuNumber
            },
            successHandler);
    };
    this.update = function (id, userId, startDate, fee, form, certif, rib, identity, secuNumber, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.UPDATE,
            {
                id: id,
                userId: userId,
                startDate: startDate,
                fee: fee,
                form: form,
                certif: certif,
                rib: rib,
                identity: identity,
                secuNumber: secuNumber
            },
            successHandler);
    };
    this.delete = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.DELETE,
            {id: id},
            successHandler);
    }

};

// ----------------------- TEAM INTERFACE SERVICES CLASS ----------------------------------

var TeamServicesInterface = new function () {

    this.meta = {
        // --- (object)
        OBJECT: 'team',
        // --- (actions)
        ACTION: {
            GET_TEAM_BY_ID: 'byidt',
            GET_TEAM_BY_DIV: 'bydivt',
            GET_TEAM_MEMBERS: 'memt',
            GET_ALL_TEAMS: 'allt',
            GET_USER_TEAMS: 'allut',
            INSERT_MEMBER: 'insmem',
            DELETE_MEMBER: 'delmem',
            INSERT: 'insert',
            UPDATE: 'update',
            DELETE: 'delete'
        }
    };

    this.getAll = function (successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_ALL_TEAMS, {}, successHandler);
    };
    this.getUserTeams = function (successHandler) {
        return DoleticServicesInterface.callService(this.meta.OBJECT, this.meta.ACTION.GET_USER_TEAMS, {}, successHandler);
    };
    this.getTeamMembers = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_TEAM_MEMBERS,
            {id: id},
            successHandler);
    };
    this.getById = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.GET_TEAM_BY_ID,
            {id: id},
            successHandler);
    };
    this.insertMember = function (id, memberId, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.INSERT_MEMBER,
            {
                id: id,
                memberId: memberId
            },
            successHandler);
    };
    this.deleteMember = function (id, memberId, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.DELETE_MEMBER,
            {
                id: id,
                memberId: memberId
            },
            successHandler);
    };
    this.insert = function (name, leaderId, division, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.INSERT,
            {
                name: name,
                leaderId: leaderId,
                division: division
            },
            successHandler);
    };
    this.update = function (id, name, leaderId, division, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.UPDATE,
            {
                id: id,
                name: name,
                leaderId: leaderId,
                division: division
            },
            successHandler);
    };
    this.delete = function (id, successHandler) {
        return DoleticServicesInterface.callService(
            this.meta.OBJECT, this.meta.ACTION.DELETE,
            {id: id},
            successHandler);
    }

};